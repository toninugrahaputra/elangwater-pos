<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('unit');
            $table->decimal('volume', 10, 2)->nullable();
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('retail_price', 15, 2);
            $table->decimal('wholesale_price', 15, 2);
            $table->decimal('agency_price', 15, 2)->nullable();
            $table->integer('minimum_stock')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
