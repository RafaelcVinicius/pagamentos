<?php

namespace App\Repositories;

use App\Models\PaymentsIntention;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PaymentIntentionRepository implements PaymentIntentionRepositoryInterface
{
    public function store(array $data) : PaymentsIntention {
        return Auth::user()->company->paymentsIntention()->create($data)->refresh();
    }

    public function index() {
        return Auth::user()->company->paymentsIntention()->get();
    }

    public function update(array $data, string $uuid) : PaymentsIntention {
        $intention = Auth::user()->company->paymentsIntention->where('uuid', $uuid)->where('payment_id', null)->firstOrFail();
        $intention->update(['webhook' => $data['webHook']]);

        return $intention->refresh();
    }

    public function show(string $uuid) : PaymentsIntention {
       return Auth::user()->company->paymentsIntention->where('uuid', $uuid)->firstOrFail();
    }
}
