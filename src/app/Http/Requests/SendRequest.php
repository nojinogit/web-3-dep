<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest
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
        'postcode' => 'required|size:8',
        'address' => 'required',
    ];
    }

    public function messages()
    {
    return [
    'postcode.size' => '郵便番号はハイフン込み8文字にて入力ください。',
    'postcode.required' => '郵便番号は必須項目です。',
    'address.required' => '住所は必須項目です。',
    ];
    }
}
