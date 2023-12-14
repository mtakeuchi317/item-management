<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }
    public function messages(): array
{
    return [
        'current_password.required' => '現在のパスワードを入力してください。',
        'current_password.string' => 'パスワードは文字列で入力してください。',
        'current_password.min' => 'パスワードは少なくとも8文字以上で入力してください。',
        'password.required' => '新しいパスワードを入力してください。',
        'password.string' => 'パスワードは文字列で入力してください。',
        'password.min' => 'パスワードは少なくとも8文字以上で入力してください。',
        'password.confirmed' => 'パスワードの確認が一致しません。',
    ];
}
    public function withValidator(Validator $validator) {
        $validator->after(function ($validator) {
            $auth = Auth::user();
            
            //現在のパスワードと新しいパスワードが合わなければエラー
            if (!(Hash::check($this->input('current_password'), $auth->password))) {
                $validator->errors()->add('current_password', __('The current password is incorrect.'));
            }
        });
    }
}
