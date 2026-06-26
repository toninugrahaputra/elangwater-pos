<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;

    protected $table = 'stock_mutations';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'reference_type',
        'reference_id',
        'reference_number',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}