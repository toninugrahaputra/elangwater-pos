<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductStockResource extends JsonResource
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
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'quantity' => $this->quantity,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'sku' => $this->product->sku,
                'barcode' => $this->product->barcode
            ],
            'warehouse' => [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
                'code' => $this->warehouse->code
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}