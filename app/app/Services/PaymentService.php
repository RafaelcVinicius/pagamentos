<?php

namespace App\Services;

use App\Http\Resources\PayerResource;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Repositories\Contracts\Gateways\PaymentGatewayRepositoryInterface;
use App\Repositories\Contracts\PayerRepositoryInterface;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PaymentService
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function store(array $data) : PaymentResource {
        $data['uuid'] = Uuid::uuid4();
        $gatewayRepository = app(PaymentGatewayRepositoryInterface::class);
        $paymentGateway = $gatewayRepository->createPayment($this->prepareDataPaymentMercadoPago($data));
        return new PaymentResource($this->paymentRepository->store($this->prepareDataStore($paymentGateway, $data)));
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

    public function webhook(array $data, string $uuid) : void {
        Log::info(json_encode($data));
        Log::info($uuid);
        // return new PaymentResource($this->paymentRepository->webhook($uuid));
    }

    private function prepareDataPaymentMercadoPago(array $data) : array
    {
        $paymentIntentionRepository = app(PaymentIntentionRepositoryInterface::class);
        $paymentIntention = $paymentIntentionRepository->show($data['paymentIntentionUuid']);

        if($paymentIntention->payer_id)
        {
            $payerRepository = app(PayerRepositoryInterface::class);
            $payer = $payerRepository->showById($paymentIntention->payer_id);

            if(!$payer->mercadoPago){
                $gatewayRepository = app(PaymentGatewayRepositoryInterface::class);
                $payerGateway = $gatewayRepository->createPayer(new PayerResource($payer));

                $payer = $payerRepository->showById($paymentIntention->payer_id);
            }

            $payer =  [
                'type'              => "customer",
                'id'                => $payer->mercadoPago->gateway_customer_id,
                'email'             => $payer->email,
                'identification'    => [
                    "type" => strlen($payer->cnpjcpf) > 11 ? "CNPJ" : "CPF",
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
            'notification_url'      => config("constants.APP_URL"). "/v1/payments/". $data['uuid'] . "/webhook",
            'external_reference'    => $data['uuid'],
            'payment_method_id'     => $data['paymentMethodId'],
            'issuer_id'             => $data['issuerId'],
            'token'                 => $data['token'],
            'installments'          => $data['installments'],
            'transaction_amount'    => (float)$paymentIntention->total_amount,
            'payer'                 => $payer
        );
    }

    private function prepareDataStore($payment, $data): array
    {
        $paymentIntentionRepository = app(PaymentIntentionRepositoryInterface::class);
        $paymentIntention = $paymentIntentionRepository->show($data['paymentIntentionUuid']);

        return array(
            "uuid" =>  $data['uuid'],
            "email" => $data['email'],
            "payment_intention_id" => $paymentIntention->id,
            "gateway_payment_id" => $payment['id'],
            "payment_type" => $data['paymentMethodId'],
            "transection_amount" => $paymentIntention->total_amount,
            "status" => array(
                "status" => $payment['status'],
                "detail" => $payment['status_detail'],
            )
        );
    }

    private function prepareDataStatus($payment): array
    {
        return array(
            "status" => $payment['status'],
            "detail" => $payment['status_detail'],
        );
    }

    private function extractStatus($payment): array
    {
        return array(
            "status" => $payment['id'],
            "detail" => $payment['paymentMethodId'],
        );
    }

}
