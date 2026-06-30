<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\WarehouseCollection;
use App\Http\Resources\WarehouseResource;
use App\Services\WarehouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = $this->warehouseService->getQuery()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('pic', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        $warehouses = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => new WarehouseCollection($warehouses),
            'meta' => [
                'current_page' => $warehouses->currentPage(),
                'from' => $warehouses->firstItem(),
                'last_page' => $warehouses->lastPage(),
                'path' => $warehouses->path(),
                'per_page' => $warehouses->perPage(),
                'to' => $warehouses->lastItem(),
                'total' => $warehouses->total()
            ]
        ]);
    }

    /**
     * Store a newly created warehouse in storage.
     */
    public function store(StoreWarehouseRequest $request): JsonResponse
    {
        $warehouse = $this->warehouseService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new WarehouseResource($warehouse),
            'message' => 'Warehouse created successfully'
        ], 201);
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
            'data' => new WarehouseResource($warehouse)
        ]);
    }

    /**
     * Update the specified warehouse in storage.
     */
    public function update(UpdateWarehouseRequest $request, string $id): JsonResponse
    {
        $warehouse = $this->warehouseService->update($id, $request->validated());

        if (!$warehouse) {
            return response()->json([
                'success' => false,
                'message' => 'Warehouse not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new WarehouseResource($warehouse),
            'message' => 'Warehouse updated successfully'
        ]);
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
}