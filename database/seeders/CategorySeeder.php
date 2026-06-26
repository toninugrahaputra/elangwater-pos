<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample categories
        Category::create([
            'name' => 'Minuman Ringan',
            'description' => 'Minuman berkarbonasi dan non-alkohol'
        ]);

        Category::create([
            'name' => 'Air Mineral',
            'description' => 'Air minum kemasan'
        ]);

        Category::create([
            'name' => 'Minuman Energi',
            'description' => 'Minuman yang mengandung elektrolit dan kafein'
        ]);

        Category::create([
            'name' => 'Teh dan Kopi',
            'description' => 'Minuman perekat bersifat Mild Stimulan'
        ]);

        Category::create([
            'name' => 'Susu dan Produk Olahan',
            'description' => 'Produk susu dan turunannya'
        ]);

        Category::create([
            'name' => 'Snack dan Cemilan',
            'description' => 'Makanan ringan untuk cemilan'
        ]);

        Category::create([
            'name' => 'Makanan Ringan',
            'description' => 'Makanan yang dapat langsung dimakan'
        ]);

        Category::create([
            'name' => 'Bumbu Dapur',
            'description' => 'Bumbu masakan dan pengawet'
        ]);

        Category::create([
            'name' => 'Minuman Alkohol',
            'description' => 'Minuman yang mengandung etanol'
        ]);

        Category::create([
            'name' => 'Produk Kebersihan',
            'description' => 'Produk untuk kebersihan pribadi dan rumah tangga'
        ]);
    }
}