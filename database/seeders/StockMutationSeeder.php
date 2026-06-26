<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockMutation;

class StockMutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample stock mutations
        // Get some products and warehouses for reference
        $products = \App\Models\Product::take(5)->get(); // First 5 products
        $warehouses = \App\Models\Warehouse::all();

        if ($products->isNotEmpty() && $warehouses->isNotEmpty()) {
            // Initial stock mutations (incoming stock)
            foreach ($products as $product) {
                foreach ($warehouses as $warehouse) {
                    // Create initial stock receipt
                    StockMutation::create([
                        'product_id' => $product->id,
                        'warehouse_id' => $warehouse->id,
                        'quantity' => rand(50, 100), // Initial stock quantity
                        'reference_type' => 'purchase',
                        'reference_id' => 1, // Reference to purchase record
                        'reference_number' => 'PO-001',
                        'notes' => 'Stok awal dari pembelian'
                    ]);

                    // Create a few sales mutations for some products
                    if ($product->id <= 3) { // Only for first 3 products
                        StockMutation::create([
                            'product_id' => $product->id,
                            'warehouse_id' => $warehouse->id,
                            'quantity' => -rand(5, 15), // Negative for outgoing stock
                            'reference_type' => 'sales',
                            'reference_id' => 1, // Reference to sales record
                            'reference_number' => 'SO-001',
                            'notes' => 'Penjualan kepada customer'
                        ]);
                    }
                }
            }
        }
    }
}