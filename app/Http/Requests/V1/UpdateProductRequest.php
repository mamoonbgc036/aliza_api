<?php

namespace App\Http\Requests\V1;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                "title" => ['required'],
                "description" => ['required'],
                "price" => ['required'],
                "old_price" => ['required'],
                "category_id" => ['required'],
                "unit" => ['required']
            ];
        } else {
            return [
                "title" => ['sometimes', 'required'],
                "description" => ['sometimes', 'required'],
                "price" => ['sometimes', 'required'],
                "old_price" => ['sometimes', 'required'],
                "category_id" => ['sometimes', 'required'],
                "unit" => ['sometimes', 'required']
            ];
        }
    }

    public function prepareForValidation()
    {
        if ($this->categoryId) {
            $this->merge([
                'category_id' => $this->categoryId,
            ]);
        }
        if ($this->oldPrice) {
            $this->merge([
                'old_price' => $this->oldPrice
            ]);
        }
    }
}
