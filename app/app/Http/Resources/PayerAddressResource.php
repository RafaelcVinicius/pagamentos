<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayerAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>             $this->id,
            "zipCode" =>        $this->zip_code,
            "streetName" =>     $this->street_name,
            "streetNumber" =>   $this->street_number,
            "city" =>           $this->city,
        ];
    }
}
