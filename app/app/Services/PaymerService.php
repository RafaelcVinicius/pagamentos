<?php

namespace App\Services;

use App\Http\Resources\PaymerResource;
use App\Repositories\Contracts\PaymerRepositoryInterface;
use App\Repositories\PaymerRepository;

class PaymerService
{
    private PaymerRepository $paymerRepository;

    public function __construct(PaymerRepositoryInterface $paymerRepository)
    {
        $this->paymerRepository = $paymerRepository;
    }

    public function store(array $data) : PaymerResource {
        return new PaymerResource($this->paymerRepository->store($data));
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : PaymerResource {
        return new PaymerResource($this->paymerRepository->update($data, $uuid));
    }

    public function showByUuid(string $uuid) : PaymerResource {
        return new PaymerResource($this->paymerRepository->showByUuid($uuid));
    }
}
