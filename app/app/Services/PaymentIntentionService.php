<?php

namespace App\Services;

use App\Http\Resources\PaymentIntentionResource;
use App\Http\Resources\payersResource;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
use App\Repositories\PaymentIntentionRepository;
use Illuminate\Support\Facades\DB;

class PaymentIntentionService
{
    private PaymentIntentionRepository $paymentIntentionRepository;

    public function __construct(PaymentIntentionRepositoryInterface $paymentIntentionRepository)
    {
        $this->paymentIntentionRepository = $paymentIntentionRepository;
    }

    public function store(array $data) : PaymentIntentionResource
    {
        $custumer = [];
        return new PaymentIntentionResource($this->paymentIntentionRepository->store($this->prepareDataStore($data)));
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

    private function prepareDataStore(array $data) : array
    {
        return array(
            'uuid'          => DB::raw('gen_random_uuid()'),
            'total_amount'  => $data['totalAmount'],
            'webhook'       => $data['webHook'],
        );
    }
}
