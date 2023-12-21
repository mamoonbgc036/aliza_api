<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // "productData.title" => ['required'],
            // "productData.description" => ['required'],
            // "productData.price" => ['required'],
            // "productData.old_price" => ['required'],
            // "productData.category_id" => ['required'],
            // "productData.unit" => ['required'],
            // 'image' => 'nullable'
        ];
    }

    // public function prepareForValidation()
    // {
    //     $this->merge([
    //         'productData.category_id' => $this->productData,
    //         'old_price' => $this->oldPrice
    //     ]);
    // }
}
