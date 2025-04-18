<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StoreProductRequest extends FormRequest
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
            'product_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name'              => 'required|string',
            'category_id'       => 'required|integer',
            'quantity'          => 'required|integer',
            'brand'             => 'required|string',
            'source'            => 'required|string',
            'dateArrival'       => 'required|date',
            'price'             => 'required|integer|min:0',
            'quantity_alert'    => 'required|integer',
            'notes'             => 'nullable|max:1000',
            'specifications'    => 'nullable|max:4000'
        ];
    }

    // protected function prepareForValidation(): void
    // {
    //     $this->merge([
    //         'slug' => Str::slug($this->name, '-'),
    //         'code' =>
    //     ]);
    // }
}
