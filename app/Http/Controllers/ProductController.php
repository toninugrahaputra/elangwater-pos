<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the products.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');

        $query = $this->productService->getQuery()
            ->with(['category', 'brand']) // eager load relationships
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => new ProductCollection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'from' => $products->firstItem(),
                'last_page' => $products->lastPage(),
                'path' => $products->path(),
                'per_page' => $products->perPage(),
                'to' => $products->lastItem(),
                'total' => $products->total()
            ]
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Product created successfully'
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->productService->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->validated());

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->productService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get product by SKU.
     */
    public function getBySku(string $sku): JsonResponse
    {
        try {
            $product = $this->productService->findBySku($sku);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new ProductResource($product)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product by barcode.
     */
    public function getByBarcode(string $barcode): JsonResponse
    {
        try {
            $product = $this->productService->findByBarcode($barcode);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new ProductResource($product)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product stock.
     */
    public function getStock(int $productId, int $warehouseId): JsonResponse
    {
        try {
            $stock = $this->productService->getProductStock($productId, $warehouseId);

            return response()->json([
                'success' => true,
                'data' => ['stock' => $stock]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, int $productId, int $warehouseId): JsonResponse
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:0'
            ]);

            $stock = $this->productService->updateStock($productId, $warehouseId, $request->quantity);

            return response()->json([
                'success' => true,
                'data' => $stock,
                'message' => 'Stock updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}