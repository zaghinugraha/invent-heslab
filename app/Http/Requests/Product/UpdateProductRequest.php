<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'quantity_alert' => 'required|integer',
            'notes' => 'nullable|max:1000',
            'specifications' => 'nullable|string|max:4000',
            'maintenance_notes' => 'nullable|string|max:1000',
            'maintenance_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

}
