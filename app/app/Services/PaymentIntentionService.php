<?php

namespace App\Services;

use App\Http\Resources\PayerResource;
use App\Http\Resources\PaymentIntentionCollection;
use App\Http\Resources\PaymentIntentionResource;
use App\Repositories\Contracts\Gateways\MercadoPagoRepositoryInterface;
use App\Repositories\Contracts\PayerRepositoryInterface;
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
        return new PaymentIntentionResource($this->paymentIntentionRepository->store($this->prepareDataStore($data)));
    }

    public function index(): PaymentIntentionCollection
    {
        return new PaymentIntentionCollection($this->paymentIntentionRepository->index());
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
        $payer = null;
        if(array_key_exists('payerUuid', $data) && !empty($data['payerUuid']))
        {
            $payerRepository = app(PayerRepositoryInterface::class);
            $payer = $payerRepository->show($data['payerUuid']);

            switch($data['gateway'])
            {
                case "MP":
                    if(empty($payer->mercadoPago))
                    {
                        $mercadoPagoRepository = app(MercadoPagoRepositoryInterface::class);
                        $payerMP = $mercadoPagoRepository->showByEmailPayer($payer->email);
                        if(empty($payerMP))
                            $payerMP = $mercadoPagoRepository->createPayer(new PayerResource($payer));
                        else
                            $payerMP = $mercadoPagoRepository->savePayerToDB($payer->uuid, $payerMP);
                    }
                break;
            }
        }

        return array(
            'uuid'          => DB::raw('gen_random_uuid()'),
            'payer_id'      => $payer?->id ?? null,
            'origen'        => empty($payer) ? '2' : '1',
            'total_amount'  => $data['totalAmount'],
            'webhook'       => $data['webHook'],
            'url_callback'  => $data['urlCallback'],
            'gateway'       => $data['gateway'],
        );
    }
}
