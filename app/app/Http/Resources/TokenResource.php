<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "accessToken"          => $this->resource['access_token'],
            "expiresIn"            => $this->resource['expires_in'],
            "refreshExpiresIn"     => $this->resource['refresh_expires_in'],
            "refreshToken"         => $this->resource['refresh_token'],
            "tokenType"            => $this->resource['token_type'],
        ];
    }
}
