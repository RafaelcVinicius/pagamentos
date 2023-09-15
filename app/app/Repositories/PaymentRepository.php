<?php

namespace App\Repositories;

use App\Models\Companies;
use App\Models\Payments;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function store(array $data) : Payments {
        return Payments::create($data);
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : Payments {
        $companies = Payments::where('uuid', $uuid)->firstOrFail();

        return $companies->update($data);
    }

    public function showByUuid(string $uuid) : Payments {
       return Payments::where('uuid', $uuid)->firstOrFail();
    }
}
