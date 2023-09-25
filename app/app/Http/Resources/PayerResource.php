<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid"          => $this->uuid,
            "email"         => $this->email,
            "firstName"     => $this->first_name,
            "lastName"      => $this->last_name,
            "cnpjCpf"       => $this->cnpjcpf,
            "dateCreate"    => $this->date_create,
            "dateUpdate"    => $this->date_update,
        ];
    }
}
