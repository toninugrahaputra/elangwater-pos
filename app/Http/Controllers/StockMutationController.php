<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StockMutationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class StockMutationController extends Controller
{
    protected $stockMutationService;

    public function __construct(StockMutationService $stockMutationService)
    {
        $this->stockMutationService = $stockMutationService;
    }

    /**
     * Display a listing of the stock mutations.
     */
    public function index(): JsonResponse
    {
        $stockMutations = $this->stockMutationService->all();
        return response()->json([
            'success' => true,
            'data' => $stockMutations
        ]);
    }

    /**
     * Store a newly created stock mutation in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateStockMutation($request);

            $stockMutation = $this->stockMutationService->create($request->all());

            return response()->json([
                'success' => true,
                'data' => $stockMutation,
                'message' => 'Stock mutation created successfully'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create stock mutation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified stock mutation.
     */
    public function show(string $id): JsonResponse
    {
        $stockMutation = $this->stockMutationService->find($id);

        if (!$stockMutation) {
            return response()->json([
                'success' => false,
                'message' => 'Stock mutation not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $stockMutation
        ]);
    }

    /**
     * Update the specified stock mutation in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $this->validateStockMutation($request, $id);

            $stockMutation = $this->stockMutationService->update($id, $request->all());

            if (!$stockMutation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock mutation not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $stockMutation,
                'message' => 'Stock mutation updated successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock mutation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified stock mutation from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->stockMutationService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Stock mutation not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock mutation deleted successfully'
        ]);
    }

    /**
     * Validate stock mutation data.
     */
    protected function validateStockMutation(Request $request, $id = null)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer',
            'reference_type' => 'nullable|string|max:50',
            'reference_id' => 'nullable|integer',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}