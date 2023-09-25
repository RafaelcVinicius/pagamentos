<?php

namespace App\Services;

use App\Http\Resources\PaymentIntentionResource;
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

    public function store(array $data) : PaymentIntentionResource
    {
        return new PaymentIntentionResource($this->paymentIntentionRepository->store($data));
    }

    public function index() : array
    {
        return [];
    }

    public function update(array $data, string $uuid) : PaymentIntentionResource
    {
        return new PaymentIntentionResource($this->paymentIntentionRepository->update($data, $uuid));
    }

    public function show(string $uuid) : PaymentIntentionResource
    {
        return new PaymentIntentionResource($this->paymentIntentionRepository->show($uuid));
    }
}
