<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductStockRequest;
use App\Http\Requests\UpdateProductStockRequest;
use App\Http\Resources\ProductStockCollection;
use App\Http\Resources\ProductStockResource;
use App\Services\ProductStockService;
use Illuminate\Http\Request;
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
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $query = $this->productStockService->getQuery();

        if ($search) {
            $query->whereHas('product', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%");
            })->orWhereHas('warehouse', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $productStocks = $query->with(['product', 'warehouse'])
            ->paginate($perPage)
            ->appends(request()->query());

        return response()->json([
            'success' => true,
            'data' => new ProductStockCollection($productStocks)
        ]);
    }

    /**
     * Store a newly created product stock in storage.
     */
    public function store(StoreProductStockRequest $request): JsonResponse
    {
        $productStock = $this->productStockService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProductStockResource($productStock),
            'message' => 'Product stock created successfully'
        ], 201);
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
            'data' => new ProductStockResource($productStock)
        ]);
    }

    /**
     * Update the specified product stock in storage.
     */
    public function update(UpdateProductStockRequest $request, string $id): JsonResponse
    {
        $productStock = $this->productStockService->update($id, $request->validated());

        if (!$productStock) {
            return response()->json([
                'success' => false,
                'message' => 'Product stock not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductStockResource($productStock),
            'message' => 'Product stock updated successfully'
        ]);
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
}