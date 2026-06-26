<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample brands
        Brand::create([
            'name' => 'Aqua',
            'description' => 'Air mineral kemasan'
        ]);

        Brand::create([
            'name' => 'Pocari Sweat',
            'description' => 'Minuman elektrolit'
        ]);

        Brand::create([
            'name' => 'Coca-Cola',
            'description' => 'Minuman ringan'
        ]);

        Brand::create([
            'name' => 'Pepsi',
            'description' => 'Minuman ringan'
        ]);

        Brand::create([
            'name' => 'Sprite',
            'description' => 'Minuman soda rasa lemon-lime'
        ]);

        Brand::create([
            'name' => 'Fanta',
            'description' => 'Minuman soda rasa jeruk'
        ]);

        Brand::create([
            'name' => 'Teh Pucuk Harum',
            'description' => 'Minuman teh siap saji'
        ]);

        Brand::create([
            'name' => 'Teh Botol Sosro',
            'description' => 'Minuman teh asli'
        ]);

        Brand::create([
            'name' => 'Ultra Milk',
            'description' => 'Susu UHT'
        ]);

        Brand::create([
            'name' => 'Indomilk',
            'description' => 'Susu kedelai'
        ]);
    }
}