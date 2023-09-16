<?php

namespace App\Services;

use App\Http\Resources\PaymentResource;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;

class PaymentService
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function store(array $data) : PaymentResource {
        return new PaymentResource($this->paymentRepository->store($data));
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : PaymentResource {
        return new PaymentResource($this->paymentRepository->update($data, $uuid));
    }

    public function showByUuid(string $uuid) : PaymentResource {
        return new PaymentResource($this->paymentRepository->showByUuid($uuid));
    }
}
