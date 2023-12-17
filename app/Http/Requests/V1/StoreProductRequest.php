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
            "title" => ['required'],
            "description" => ['required'],
            "price" => ['required'],
            "oldPrice" => ['required'],
            "categoryId" => ['required'],
            "unit" => ['required']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->categoryId,
            'old_price' => $this->oldPrice
        ]);
    }
}
