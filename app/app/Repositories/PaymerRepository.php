<?php

namespace App\Repositories;

use App\Models\Paymer;
use App\Repositories\Contracts\PaymerRepositoryInterface;

class PaymerRepository implements PaymerRepositoryInterface
{
    public function store(array $data) : Paymer {
        return Paymer::create($data);
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : Paymer {
        $companies = Paymer::where('uuid', $uuid)->firstOrFail();

        return $companies->update($data);
    }

    public function showByUuid(string $uuid) : Paymer {
       return Paymer::where('uuid', $uuid)->firstOrFail();
    }
}
