<?php

namespace App\Http\Requests\Payment;

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
            "paymentIntentionUuid"      => ['required', 'uuid'],
            "paymentMethodId"           => ['required', 'string', 'min:1'],
            "issuerId"                  => ['int', 'min:1'],
            "token"                     => ['string', 'min:10', 'max:100'],
            "installments"              => ['required', 'int', 'min:1'],
            "email"                     => ['email'],
        ];
    }
}
