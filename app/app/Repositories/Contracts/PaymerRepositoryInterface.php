<?php

namespace App\Repositories\Contracts;

interface PaymerRepositoryInterface
{
    public function store(array $data);
    public function show();
    public function update(array $data, string $uuid);
    public function showByUuid(string $uuid);
}
