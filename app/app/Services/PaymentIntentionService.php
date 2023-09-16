<?php

namespace App\Services;

use App\Http\Resources\PaymerResource;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
use App\Repositories\PaymentIntentionRepository;

class PaymentIntentionService
{
    private PaymentIntentionRepository $paymentIntentionRepository;

    public function __construct(PaymentIntentionRepositoryInterface $paymentIntentionRepository)
    {
        $this->paymentIntentionRepository = $paymentIntentionRepository;
    }

    public function store(array $data) : PaymerResource {
        return new PaymerResource($this->paymentIntentionRepository->store($data));
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : PaymerResource {
        return new PaymerResource($this->paymentIntentionRepository->update($data, $uuid));
    }

    public function showByUuid(string $uuid) : PaymerResource {
        return new PaymerResource($this->paymentIntentionRepository->showByUuid($uuid));
    }
}
