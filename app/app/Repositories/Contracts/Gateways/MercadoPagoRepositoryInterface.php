<?php

namespace App\Repositories\Contracts\Gateways;

use App\Http\Resources\PayerResource;

interface MercadoPagoRepositoryInterface
{
    public function auth(array $data);
    public function createPayer(PayerResource $data);
    public function showByEmailPayer(string $email);
    public function show(string $uuid);
}
