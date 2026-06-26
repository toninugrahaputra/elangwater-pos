<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WarehouseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class WarehouseController extends Controller
{
    protected $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    /**
     * Display a listing of the warehouses.
     */
    public function index(): JsonResponse
    {
        $warehouses = $this->warehouseService->all();
        return response()->json([
            'success' => true,
            'data' => $warehouses
        ]);
    }

    /**
     * Store a newly created warehouse in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateWarehouse($request);

            $warehouse = $this->warehouseService->create($request->all());

            return response()->json([
                'success' => true,
                'data' => $warehouse,
                'message' => 'Warehouse created successfully'
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
                'message' => 'Failed to create warehouse',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified warehouse.
     */
    public function show(string $id): JsonResponse
    {
        $warehouse = $this->warehouseService->find($id);

        if (!$warehouse) {
            return response()->json([
                'success' => false,
                'message' => 'Warehouse not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $warehouse
        ]);
    }

    /**
     * Update the specified warehouse in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $this->validateWarehouse($request, $id);

            $warehouse = $this->warehouseService->update($id, $request->all());

            if (!$warehouse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $warehouse,
                'message' => 'Warehouse updated successfully'
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
                'message' => 'Failed to update warehouse',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified warehouse from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->warehouseService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Warehouse not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Warehouse deleted successfully'
        ]);
    }

    /**
     * Validate warehouse data.
     */
    protected function validateWarehouse(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . ($id ?? ''),
            'address' => 'nullable|string',
            'pic' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}