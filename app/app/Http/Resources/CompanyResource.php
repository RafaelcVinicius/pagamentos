<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            "businessName"  => $this->business_name,
            "gateway"       => new GatewayResource($this),
            "updatedAt"     => $this->updated_at,
            "createdAt"     => $this->created_at,
        ];
    }
}
