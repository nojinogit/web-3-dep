<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'name' => 'required',
            'image' => 'required',
            'brand' => 'required',
            'condition' => 'required',
            'explanation' => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
    return [
    'condition.required' => '商品の状態は必須項目です。',
    'brand.required' => 'ブランド・メーカー名は必須項目です。',
    'explanation.required' => '商品の説明は必須項目です。',
    ];
    }
}
