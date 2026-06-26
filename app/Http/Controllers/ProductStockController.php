<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductStockService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ProductStockController extends Controller
{
    protected $productStockService;

    public function __construct(ProductStockService $productStockService)
    {
        $this->productStockService = $productStockService;
    }

    /**
     * Display a listing of the product stocks.
     */
    public function index(): JsonResponse
    {
        $productStocks = $this->productStockService->all();
        return response()->json([
            'success' => true,
            'data' => $productStocks
        ]);
    }

    /**
     * Store a newly created product stock in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateProductStock($request);

            $productStock = $this->productStockService->create($request->all());

            return response()->json([
                'success' => true,
                'data' => $productStock,
                'message' => 'Product stock created successfully'
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
                'message' => 'Failed to create product stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified product stock.
     */
    public function show(string $id): JsonResponse
    {
        $productStock = $this->productStockService->find($id);

        if (!$productStock) {
            return response()->json([
                'success' => false,
                'message' => 'Product stock not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $productStock
        ]);
    }

    /**
     * Update the specified product stock in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $this->validateProductStock($request, $id);

            $productStock = $this->productStockService->update($id, $request->all());

            if (!$productStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product stock not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $productStock,
                'message' => 'Product stock updated successfully'
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
                'message' => 'Failed to update product stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified product stock from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->productStockService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Product stock not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product stock deleted successfully'
        ]);
    }

    /**
     * Validate product stock data.
     */
    protected function validateProductStock(Request $request, $id = null)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:0'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}