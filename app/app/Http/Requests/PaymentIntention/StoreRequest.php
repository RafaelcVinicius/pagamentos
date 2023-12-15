<?php

namespace App\Http\Requests\PaymentIntention;

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
            "payerUuid"     => ['uuid'],
            "origin"        => ['string', 'max:1'],
            "totalAmount"   => ['required', 'numeric'],
            "gateway"       => ['required', 'string', 'min:1', 'max:2'],
            "urlCallback"   => ['required', 'string', 'min:10', 'max:100'],
            "webHook"       => ['required', 'string', 'min:10', 'max:100'],
            "items"         => ['array'],
        ];
    }
}
