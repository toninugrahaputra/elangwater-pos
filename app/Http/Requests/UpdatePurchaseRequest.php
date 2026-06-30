<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'sometimes|required|exists:users,id',
            'purchase_date' => 'sometimes|required|date',
            'total_amount' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:pending,completed,cancelled',
            'items' => 'sometimes|required|array',
            'items.*.product_id' => 'sometimes|required|exists:products,id',
            'items.*.quantity' => 'sometimes|required|integer|min:1',
            'items.*.unit_price' => 'sometimes|required|numeric|min:0',
        ];
    }
}