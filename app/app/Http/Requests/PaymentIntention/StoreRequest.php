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
            "payerUuid"                             => ['uuid'],
            "origin"                                => ['string', 'max:1'],
            "totalAmount"                           => ['required', 'numeric'],
            "gateway"                               => ['required', 'string', 'min:1', 'max:2'],
            "callbackUrl"                           => ['required', 'string', 'min:10', 'max:100'],
            "webHook"                               => ['required', 'string', 'min:10', 'max:100'],
            "additionalInfo.items"                  => ['array'],
            "additionalInfo.items.*.id"             => ['required_with:additionalInfo.items', 'string'],
            "additionalInfo.items.*.title"          => ['required_with:additionalInfo.items', 'string'],
            "additionalInfo.items.*.description"    => ['string'],
            "additionalInfo.items.*.picture_url"    => ['string'],
            "additionalInfo.items.*.category_id"    => ['string'],
            "additionalInfo.items.*.quantity"       => ['required_with:additionalInfo.items', 'numeric'],
            "additionalInfo.items.*.unit_price"     => ['required_with:additionalInfo.items', 'numeric'],
            "additionalInfo.items.*.type"           => ['string'],
            "additionalInfo.items.*.warranty"       => ['boolean'],
        ];
    }
}
