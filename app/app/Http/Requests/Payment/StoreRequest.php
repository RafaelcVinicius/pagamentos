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
            "payerUuid"     => ['required', 'uuid'],
            "paymentType"  => ['required', 'string', 'min:3', 'max:20'],
            "origemAmount"  => ['required', 'decimal:0,2'],
            "gateway"       => ['required', 'string', 'min:1', 'max:2'],
            "webHook"       => ['required', 'string', 'min:10', 'max:100'],
        ];
    }
}
