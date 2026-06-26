<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'barcode',
        'name',
        'category_id',
        'brand_id',
        'unit',
        'volume',
        'purchase_price',
        'retail_price',
        'wholesale_price',
        'agency_price',
        'minimum_stock',
        'status',
        'image_path'
    ];

    protected $casts = [
        'volume' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'retail_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'agency_price' => 'decimal:2',
        'minimum_stock' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}