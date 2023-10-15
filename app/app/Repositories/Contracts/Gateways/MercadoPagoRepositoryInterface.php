<?php

namespace App\Repositories\Contracts\Gateways;

interface MercadoPagoRepositoryInterface
{
    public function auth(array $data);
    public function store(array $data);
    public function update(string $uuid, array $data);
    public function show(string $uuid);
}
