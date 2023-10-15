<?php

namespace App\Repositories\Contracts;

interface GatewayRepositoryInterface
{
    public function index();
    public function store(array $data);
    public function update(string $uuid, array $data);
    public function show(string $type);
}
