<?php

namespace App\Services;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Repositories\Contracts\PayerRepositoryInterface;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
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
        $paymentIntentionRepository = app(PaymentIntentionRepositoryInterface::class);
        $paymentIntention = $paymentIntentionRepository->show($data['paymentIntentionUuid']);

        if($paymentIntention->payer_id)
        {
            $payerRepository = app(PayerRepositoryInterface::class);
            $payer = $payerRepository->showById($paymentIntention->payer_id);

            $payer =  [
                'type'              => "customer",
                'id'                => $payer->mercadoPago->gateway_customer_id,
                'email'             => $payer->email,
                'identification'    => [
                    "type" => Strlen($payer->cnpjcpf) > 11 ? "CNPJ" : "CPF",
                    "number" => $payer->cnpjcpf,
                ],
                'first_name'        => $payer->first_name,
                'last_name'         => $payer->last_name,
            ];
        }
        else
        {
            $payer =  [
                'type'      => "guest",
                'email'     => $data['email'],
            ];
        }

        return array(
            'uuid'                  => DB::raw('gen_random_uuid()'),
            'payment_method_id'     => $data['paymentMethodId'],
            'issuer_id'             => $data['issuerId'],
            'token'                 => $data['token'],
            'installments'          => $data['installments'],
            'transaction_amount'    => $paymentIntention->total_amount,
            'payer'                 => $payer
        );
    }
}
