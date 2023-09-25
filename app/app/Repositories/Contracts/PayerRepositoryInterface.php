<?php

namespace App\Repositories\Contracts;

interface PayerRepositoryInterface
{
    public function store(array $data);
    public function index();
    public function update(string $uuid, array $data);
    public function show(string $uuid);
}
