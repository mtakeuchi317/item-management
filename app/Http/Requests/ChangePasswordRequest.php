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
