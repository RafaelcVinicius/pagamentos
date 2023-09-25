<?php

namespace App\Repositories;

use App\Models\PaymentsIntention;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;

class PaymentIntentionRepository implements PaymentIntentionRepositoryInterface
{
    public function store(array $data) : PaymentsIntention {
        return PaymentsIntention::create($data);
    }

    public function index() : array {
        return [];
    }

    public function update(array $data, string $uuid) : PaymentsIntention {
        $companies = PaymentsIntention::where('uuid', $uuid)->firstOrFail();

        return $companies->update($data);
    }

    public function show(string $uuid) : PaymentsIntention {
       return PaymentsIntention::where('uuid', $uuid)->firstOrFail();
    }
}
