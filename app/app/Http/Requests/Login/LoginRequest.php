<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'grantType' =>      ['required', 'string'],
            'refreshToken' =>   ['missing_unless:grantType,refresh_token', 'string'],
            'email' =>          ['missing_unless:grantType,authorization_code', 'email'],
            'password' =>       ['missing_unless:grantType,authorization_code', 'string', 'min:6', 'max:20'],
        ];
    }
}
