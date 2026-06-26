<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

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
    public function index(): JsonResponse
    {
        $products = $this->productService->all();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateProduct($request);

            $product = $this->productService->create($request->all());

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product created successfully'
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
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
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
            'data' => $product
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $this->validateProduct($request, $id);

            $product = $this->productService->update($id, $request->all());

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product updated successfully'
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
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
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
                'data' => $product
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
                'data' => $product
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
        } catch (ValidationException $e) {
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

    /**
     * Validate product data.
     */
    protected function validateProduct(Request $request, $id = null)
    {
        $rules = [
            'sku' => 'required|string|max:50|unique:products,sku,' . ($id ?? ''),
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . ($id ?? ''),
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit' => 'required|string|max:50',
            'volume' => 'nullable|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'agency_price' => 'nullable|numeric|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'status' => 'in:active,inactive'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}