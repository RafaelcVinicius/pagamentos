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
            "firstName"=> ['string', 'min:3', 'max:20'],
            "lastName"=> ['string', 'min:3', 'max:30'],
            'email' => ['min:3', 'max:100', 'email'],
            "cnpjCpf"=> ['string', 'min:11', 'max:14',],
        ];
    }
}
