<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductStock;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create initial stock levels for products in warehouses
        // Assuming we have default warehouses with IDs 1 and 2

        // Get all products
        $products = \App\Models\Product::all();

        // Warehouse 1 (Gudang Pusat) - Main warehouse
        foreach ($products as $product) {
            ProductStock::create([
                'product_id' => $product->id,
                'warehouse_id' => 1,
                'quantity' => rand(50, 200) // Random initial stock between 50-200
            ]);
        }

        // Warehouse 2 (Gudang Cabang) - Branch warehouse with lower stock
        foreach ($products as $product) {
            ProductStock::create([
                'product_id' => $product->id,
                'warehouse_id' => 2,
                'quantity' => rand(10, 50) // Random initial stock between 10-50
            ]);
        }
    }
}