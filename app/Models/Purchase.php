<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}