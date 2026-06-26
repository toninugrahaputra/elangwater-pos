<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get brand and category IDs for foreign key references
        $aquaBrand = \App\Models\Brand::where('name', 'Aqua')->first()->id ?? 1;
        $pocariBrand = \App\Models\Brand::where('name', 'Pocari Sweat')->first()->id ?? 2;
        $cocaColaBrand = \App\Models\Brand::where('name', 'Coca-Cola')->first()->id ?? 3;
        $pepsiBrand = \App\Models\Brand::where('name', 'Pepsi')->first()->id ?? 4;
        $spriteBrand = \App\Models\Brand::where('name', 'Sprite')->first()->id ?? 5;
        $fantaBrand = \App\Models\Brand::where('name', 'Fanta')->first()->id ?? 6;
        /**
         * Find the Teh Pucuk Harum brand
         * or return 7 if not found
         */
        $tehPucukBrand = \App\Models\Brand::where('name', 'Teh Pucuk Harum')->first();
        $tehPucukBrandId = $tehPucukBrand ? $tehPucukBrand->id : 7;
        $tehBotolBrand = \App\Models\Brand::where('name', 'Teh Botol Sosro')->first();
        $tehBotolBrandId = $tehBotolBrand ? $tehBotolBrand->id : 8;
        $ultraMilkBrand = \App\Models\Brand::where('name', 'Ultra Milk')->first();
        $ultraMilkBrandId = $ultraMilkBrand ? $ultraMilkBrand->id : 9;
        $indomilkBrand = \App\Models\Brand::where('name', 'Indomilk')->first();
        $indomilkBrandId = $indomilkBrand ? $indomilkBrand->id : 10;

        /**
         * Find the Minuman Ringan category
         * or return 1 if not found
         */
        $minumanRinganCategory = \App\Models\Category::where('name', 'Minuman Ringan')->first();
        $minumanRinganCategoryId = $minumanRinganCategory ? $minumanRinganCategory->id : 1;
        /**
         * Find the category or 2 if not found
        */
        $airMineralCategory = \App\Models\Category::where('name', 'Air Mineral')->first();
        $airMineralCategoryId = $airMineralCategory ? $airMineralCategory->id : 2;
        /**
         * Find the Minuman Energi category
         * or return 3 if not found
         */
        $minumanEnergiCategory = \App\Models\Category::where('name', 'Minuman Energi')->first();
        $minumanEnergiCategoryId = $minumanEnergiCategory ? $minumanEnergiCategory->id : 3;
        /**
         * Find the Teh dan Kopi category
         * or return 4 if not
         */
        $tehKopiCategory = \App\Models\Category::where('name', 'Teh dan Kopi')->first();
        $tehKopiCategoryId = $tehKopiCategory ? $tehKopiCategory->id : 4;
        /**
         * Find the Susu dan Produk Olahan category
         * or return 5 if not found
         */
        $susuOlahanCategory = \App\Models\Category::where('name', 'Susu dan Produk Olahan')->first();
        $susuOlahanCategoryId = $susuOlahanCategory ? $susuOlahanCategory->id : 5;

        // Create sample products
        Product::create([
            'sku' => 'AQ-600ML',
            'name' => 'Aqua Galon 600ml',
            'brand_id' => $aquaBrand,
            'category_id' => $airMineralCategoryId,
            'unit' => 'botol',
            'volume' => 0.6,
            'purchase_price' => 2500,
            'retail_price' => 3000,
            'wholesale_price' => 2800,
            'minimum_stock' => 50,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'AQ-1500ML',
            'name' => 'Aqua Galon 1500ml',
            'brand_id' => $aquaBrand,
            'category_id' => $airMineralCategoryId,
            'unit' => 'botol',
            'volume' => 1.5,
            'purchase_price' => 4500,
            'retail_price' => 5500,
            'wholesale_price' => 5000,
            'minimum_stock' => 30,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'PC-350ML',
            'name' => 'Pocari Sweat 350ml',
            'brand_id' => $pocariBrand,
            'category_id' => $minumanEnergiCategoryId,
            'unit' => 'botol',
            'volume' => 0.35,
            'purchase_price' => 4000,
            'retail_price' => 5000,
            'wholesale_price' => 4500,
            'minimum_stock' => 40,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'CC-330ML',
            'name' => 'Coca-Cola 330ml',
            'brand_id' => $cocaColaBrand,
            'category_id' => $minumanRinganCategoryId,
            'unit' => 'botol',
            'volume' => 0.33,
            'purchase_price' => 3500,
            'retail_price' => 4500,
            'wholesale_price' => 4000,
            'minimum_stock' => 60,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'PEP-330ML',
            'name' => 'Pepsi 330ml',
            'brand_id' => $pepsiBrand,
            'category_id' => $minumanRinganCategoryId,
            'unit' => 'botol',
            'volume' => 0.33,
            'purchase_price' => 3400,
            'retail_price' => 4400,
            'wholesale_price' => 3900,
            'minimum_stock' => 50,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'SPT-330ML',
            'name' => 'Sprite 330ml',
            'brand_id' => $spriteBrand,
            'category_id' => $minumanRinganCategoryId,
            'unit' => 'botol',
            'volume' => 0.33,
            'purchase_price' => 3400,
            'retail_price' => 4400,
            'wholesale_price' => 3900,
            'minimum_stock' => 50,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'FNT-330ML',
            'name' => 'Fanta 330ml',
            'brand_id' => $fantaBrand,
            'category_id' => $minumanRinganCategoryId,
            'unit' => 'botol',
            'volume' => 0.33,
            'purchase_price' => 3400,
            'retail_price' => 4400,
            'wholesale_price' => 3900,
            'minimum_stock' => 50,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'TPH-500ML',
            'name' => 'Teh Pucuk Harum 500ml',
            'brand_id' => $tehPucukBrandId,
            'category_id' => $tehKopiCategoryId,
            'unit' => 'botol',
            'volume' => 0.5,
            'purchase_price' => 3000,
            'retail_price' => 4000,
            'wholesale_price' => 3500,
            'minimum_stock' => 40,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'TBS-500ML',
            'name' => 'Teh Botol Sosro 500ml',
            'brand_id' => $tehBotolBrandId,
            'category_id' => $tehKopiCategoryId,
            'unit' => 'botol',
            'volume' => 0.5,
            'purchase_price' => 2800,
            'retail_price' => 3800,
            'wholesale_price' => 3300,
            'minimum_stock' => 40,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'ULM-200ML',
            'name' => 'Ultra Milk 200ml',
            'brand_id' => $ultraMilkBrandId,
            'category_id' => $susuOlahanCategoryId,
            'unit' => 'botol',
            'volume' => 0.2,
            'purchase_price' => 5000,
            'retail_price' => 6500,
            'wholesale_price' => 6000,
            'minimum_stock' => 30,
            'status' => 'active'
        ]);

        Product::create([
            'sku' => 'IDM-200ML',
            'name' => 'Indomilk 200ml',
            'brand_id' => $indomilkBrandId,
            'category_id' => $susuOlahanCategoryId,
            'unit' => 'botol',
            'volume' => 0.2,
            'purchase_price' => 4500,
            'retail_price' => 6000,
            'wholesale_price' => 5500,
            'minimum_stock' => 30,
            'status' => 'active'
        ]);
    }
}