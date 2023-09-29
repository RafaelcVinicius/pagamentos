<?php

namespace App\Services;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Repositories\Contracts\PayerRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function store(array $data) : PaymentResource {
        return new PaymentResource($this->paymentRepository->store($this->prepareDataStore($data)));
    }

    public function index(): PaymentCollection {
        return new PaymentCollection($this->paymentRepository->index());
    }

    public function update(array $data, string $uuid) : PaymentResource {
        return new PaymentResource($this->paymentRepository->update($data, $uuid));
    }

    public function show(string $uuid) : PaymentResource {
        return new PaymentResource($this->paymentRepository->show($uuid));
    }

    private function prepareDataStore(array $data) : array
    {
        $payerRepository = app(PayerRepositoryInterface::class);
        $payer = $payerRepository->show($data['payerUuid']);

        return array(
            'uuid'          => DB::raw('gen_random_uuid()'),
            'payer_id'      => $payer->id,
            'payment_type'  => $data['paymentType'],
            'origem_amount' => $data['origemAmount'],
            'webhook'       => $data['webHook'],
            'gateway'       => $data['gateway'],
        );
    }
}
