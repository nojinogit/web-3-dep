<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;

class PurchaseRequest extends FormRequest
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

    public function withValidator($validator)
    {
    $validator->after(function ($validator) {
        $user = User::findOrFail(Auth::user()->id);
        $usePoint = (int) $this->input('usePoint');
        if ($usePoint > $user->point) {
            $validator->errors()->add('usePoint', 'ポイント利用が残高を超えています。');
        }
        if ($usePoint < 0) {
            $validator->errors()->add('usePoint', 'ポイント利用の最小値は0です。');
        }
    });
    }

    public function messages()
    {
    return [
    'postcode.size' => '郵便番号はハイフン込み8文字にて入力ください。',
    'postcode.required' => '郵便番号は必須項目です。',
    'address.required' => '住所は必須項目です。',
    ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->redirect = url('/purchase/' . $this->item_id);
        parent::failedValidation($validator);
    }
}
