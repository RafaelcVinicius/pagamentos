<?php

namespace App\Repositories\Contracts;

interface PaymentRepositoryInterface
{
    public function store(array $data);
    public function index();
    public function update(array $data, string $uuid);
    public function show(string $uuid);
}
