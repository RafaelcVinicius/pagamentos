<?php

namespace App\Http\Requests\payers;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "firstName"=> ['required', 'string', 'min:3', 'max:20'],
            "lastName"=> ['required', 'string', 'min:3', 'max:30'],
            'email' => ['required', 'min:3', 'max:100', 'email'],
            "cnpjCpf"=> ['required', 'string', 'min:11', 'max:14',],
        ];
    }
}
