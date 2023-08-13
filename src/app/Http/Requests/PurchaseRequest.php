<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $user = User::findOrFail(Auth::user()->id);
        $usePoint = (int) $this->input('usePoint');
        return [
        'postcode' => 'required|size:8',
        'address' => 'required',
        'usePoint' => ['max:'.$user->point],
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
    });
    }

    public function messages()
    {
    return [
    'postcode.size' => '郵便番号はハイフン込み8文字にて入力ください。',
    'postcode.required' => '郵便番号は必須項目です。',
    'usePoint.max' => 'ポイント利用が残高を超えています。',
    ];
    }
}
