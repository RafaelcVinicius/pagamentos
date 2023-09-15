<?php

namespace App\Repositories;

use App\Models\PaymentsIntention;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;

class PaymentIntentionRepository implements PaymentIntentionRepositoryInterface
{
    public function store(array $data) : PaymentsIntention {
        return PaymentsIntention::create($data);
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : PaymentsIntention {
        $companies = PaymentsIntention::where('uuid', $uuid)->firstOrFail();

        return $companies->update($data);
    }

    public function showByUuid(string $uuid) : PaymentsIntention {
       return PaymentsIntention::where('uuid', $uuid)->firstOrFail();
    }
}
