<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->group(function () {
    // Read-only routes accessible to all roles (superadmin, admin-toko, kasir)
    Route::middleware('role:superadmin|admin-toko|kasir')->group(function () {
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

        // Unit read
        Route::get('units', [UnitController::class, 'index']);
        Route::get('units/{id}', [UnitController::class, 'show']);

        // Customer read
        Route::get('customers', [CustomerController::class, 'index']);
        Route::get('customers/{id}', [CustomerController::class, 'show']);

        // Supplier read
        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::get('suppliers/{id}', [SupplierController::class, 'show']);

        // Purchase read
        Route::get('purchases', [PurchaseController::class, 'index']);
        Route::get('purchases/{id}', [PurchaseController::class, 'show']);

        // Cash transaction read
        Route::get('cash-transactions', [CashTransactionController::class, 'index']);
        Route::get('cash-transactions/{id}', [CashTransactionController::class, 'show']);

        // Current user
        Route::get('/user', [UserController::class, 'me']);
    });

    // Write operations accessible to superadmin and admin-toko
    Route::middleware('role:superadmin|admin-toko')->group(function () {
        // Update stock quantity via product/stock endpoint
        Route::post('products/{productId}/stock/{warehouseId}', [ProductController::class, 'updateStock']);
        // Create stock mutations (goods receipt/issue)
        Route::post('stock-mutations', [StockMutationController::class, 'store']);
    });

    // Super Admin only write operations (Full CRUD)
    Route::middleware('role:superadmin')->group(function () {
        // Product CRUD
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

        // ProductStock CRUD
        Route::post('product-stocks', [ProductStockController::class, 'store']);
        Route::put('product-stocks/{id}', [ProductStockController::class, 'update']);
        Route::patch('product-stocks/{id}', [ProductStockController::class, 'update']);
        Route::delete('product-stocks/{id}', [ProductStockController::class, 'destroy']);

        // StockMutation CRUD (update, delete)
        Route::put('stock-mutations/{id}', [StockMutationController::class, 'update']);
        Route::patch('stock-mutations/{id}', [StockMutationController::class, 'update']);
        Route::delete('stock-mutations/{id}', [StockMutationController::class, 'destroy']);

        // Unit CRUD
        Route::post('units', [UnitController::class, 'store']);
        Route::put('units/{id}', [UnitController::class, 'update']);
        Route::patch('units/{id}', [UnitController::class, 'update']);
        Route::delete('units/{id}', [UnitController::class, 'destroy']);

        // Customer CRUD
        Route::post('customers', [CustomerController::class, 'store']);
        Route::put('customers/{id}', [CustomerController::class, 'update']);
        Route::patch('customers/{id}', [CustomerController::class, 'update']);
        Route::delete('customers/{id}', [CustomerController::class, 'destroy']);

        // Supplier CRUD
        Route::post('suppliers', [SupplierController::class, 'store']);
        Route::put('suppliers/{id}', [SupplierController::class, 'update']);
        Route::patch('suppliers/{id}', [SupplierController::class, 'update']);
        Route::delete('suppliers/{id}', [SupplierController::class, 'destroy']);

        // Purchase CRUD
        Route::post('purchases', [PurchaseController::class, 'store']);
        Route::put('purchases/{id}', [PurchaseController::class, 'update']);
        Route::patch('purchases/{id}', [PurchaseController::class, 'update']);
        Route::delete('purchases/{id}', [PurchaseController::class, 'destroy']);

        // CashTransaction CRUD
        Route::post('cash-transactions', [CashTransactionController::class, 'store']);
        Route::put('cash-transactions/{id}', [CashTransactionController::class, 'update']);
        Route::patch('cash-transactions/{id}', [CashTransactionController::class, 'update']);
        Route::delete('cash-transactions/{id}', [CashTransactionController::class, 'destroy']);
    });
});