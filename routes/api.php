<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned to the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Read-only routes accessible to all roles (Super Admin, Store Admin, Warehouse Staff)
    Route::middleware('role:Super Admin|Store Admin|Warehouse Staff')->group(function () {
        // Product read
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);
        Route::get('products/sku/{sku}', [ProductController::class, 'getBySku']);
        Route::get('products/barcode/{barcode}', [ProductController::class, 'getByBarcode']);
        Route::get('products/{productId}/stock/{warehouseId}', [ProductController::class, 'getStock']);

        // Category read
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{id}', [CategoryController::class, 'show']);

        // Brand read
        Route::get('brands', [BrandController::class, 'index']);
        Route::get('brands/{id}', [BrandController::class, 'show']);

        // Warehouse read
        Route::get('warehouses', [WarehouseController::class, 'index']);
        Route::get('warehouses/{id}', [WarehouseController::class, 'show']);

        // Product stock read
        Route::get('product-stocks', [ProductStockController::class, 'index']);
        Route::get('product-stocks/{id}', [ProductStockController::class, 'show']);

        // Stock mutation read
        Route::get('stock-mutations', [StockMutationController::class, 'index']);
        Route::get('stock-mutations/{id}', [StockMutationController::class, 'show']);

        // Current user
        Route::get('/user', [UserController::class, 'me']);
    });

    // Warehouse staff (and Super Admin) write operations
    Route::middleware('role:Super Admin|Warehouse Staff')->group(function () {
        // Update stock quantity via product/stock endpoint
        Route::post('products/{productId}/stock/{warehouseId}', [ProductController::class, 'updateStock']);
        // Create stock mutations (goods receipt/issue)
        Route::post('stock-mutations', [StockMutationController::class, 'store']);
    });

    // Super Admin only write operations
    Route::middleware('role:Super Admin')->group(function () {
        // Product CRUD (create, update, delete)
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::patch('products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);

        // Category CRUD
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{id}', [CategoryController::class, 'update']);
        Route::patch('categories/{id}', [CategoryController::class, 'update']);
        Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

        // Brand CRUD
        Route::post('brands', [BrandController::class, 'store']);
        Route::put('brands/{id}', [BrandController::class, 'update']);
        Route::patch('brands/{id}', [BrandController::class, 'update']);
        Route::delete('brands/{id}', [BrandController::class, 'destroy']);

        // Warehouse CRUD
        Route::post('warehouses', [WarehouseController::class, 'store']);
        Route::put('warehouses/{id}', [WarehouseController::class, 'update']);
        Route::patch('warehouses/{id}', [WarehouseController::class, 'update']);
        Route::delete('warehouses/{id}', [WarehouseController::class, 'destroy']);

        // ProductStock CRUD (create, update, delete)
        Route::post('product-stocks', [ProductStockController::class, 'store']);
        Route::put('product-stocks/{id}', [ProductStockController::class, 'update']);
        Route::patch('product-stocks/{id}', [ProductStockController::class, 'update']);
        Route::delete('product-stocks/{id}', [ProductStockController::class, 'destroy']);

        // StockMutation CRUD (update, delete) – create already allowed for Warehouse Staff
        Route::put('stock-mutations/{id}', [StockMutationController::class, 'update']);
        Route::patch('stock-mutations/{id}', [StockMutationController::class, 'update']);
        Route::delete('stock-mutations/{id}', [StockMutationController::class, 'destroy']);
    });
});