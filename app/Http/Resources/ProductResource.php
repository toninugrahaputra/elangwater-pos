<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'name' => $this->name,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ] : null,
            'brand' => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ] : null,
            'unit' => $this->unit,
            'volume' => $this->volume,
            'purchase_price' => $this->purchase_price,
            'retail_price' => $this->retail_price,
            'wholesale_price' => $this->wholesale_price,
            'agency_price' => $this->agency_price,
            'minimum_stock' => $this->minimum_stock,
            'status' => $this->status,
            'image_path' => $this->image_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}