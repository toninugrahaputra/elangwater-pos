<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:50|unique:products,sku,'.$this->route('product'),
            'barcode' => 'nullable|string|max:50|unique:products,barcode,'.$this->route('product'),
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit' => 'required|string|max:50',
            'volume' => 'nullable|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'agency_price' => 'nullable|numeric|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'status' => 'in:active,inactive',
            'image_path' => 'nullable|string|max:255',
        ];
    }
}
