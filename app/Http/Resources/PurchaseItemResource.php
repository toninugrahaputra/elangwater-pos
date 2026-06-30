<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'product' => $this->product ? [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'sku' => $this->product->sku,
                'barcode' => $this->product->barcode
            ] : null,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->quantity * $this->unit_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}