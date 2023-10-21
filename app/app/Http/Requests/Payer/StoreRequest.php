<?php

namespace App\Http\Requests\Payer;

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
            "firstName"=>       ['required', 'string', 'min:3', 'max:20'],
            "lastName"=>        ['required', 'string', 'min:3', 'max:30'],
            'email' =>          ['required', 'min:3', 'max:100', 'email'],
            "cnpjCpf"=>         ['required', 'string', 'min:11', 'max:14'],
            "address" =>        ['required', 'array'],
            "address.zipCode" =>        ['required', 'string', 'min:8', 'max:10'],
            "address.streetName" =>     ['required', 'string', 'min:3', 'max:100'],
            "address.streetNumber" =>   ['required', 'int', 'min:1', 'max:6'],
            "address.city" =>           ['required', 'string', 'min:3', 'max:100'],
        ];
    }
}
