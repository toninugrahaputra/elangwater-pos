<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class,
            ProductSeeder::class,
            ProductStockSeeder::class,
            StockMutationSeeder::class,
        ]);
    }
}