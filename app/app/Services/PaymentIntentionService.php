<?php

namespace App\Services;

use App\Http\Resources\PayerResource;
use App\Http\Resources\PaymentIntentionCollection;
use App\Http\Resources\PaymentIntentionResource;
use App\Repositories\Contracts\Gateways\PaymentGatewayRepositoryInterface;
use App\Repositories\Contracts\PayerRepositoryInterface;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
use App\Repositories\PaymentIntentionRepository;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentIntentionService
{
    private PaymentIntentionRepository $paymentIntentionRepository;

    public function __construct(PaymentIntentionRepositoryInterface $paymentIntentionRepository)
    {
        $this->paymentIntentionRepository = $paymentIntentionRepository;
    }

    public function store(array $data) : PaymentIntentionResource
    {
        $data['uuid'] = Uuid::uuid4();
        $gateway = app(PaymentGatewayRepositoryInterface::class);
        $preferences = $gateway->createPreferences($this->prepareDataPreferences($data));

        return new PaymentIntentionResource($this->paymentIntentionRepository->store($this->prepareDataStore($preferences, $data)));
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

    public function webhook(array $data, string $uuid) : void
    {
        Log::info("webhook");
        Log::info(json_encode($data));
        Log::info($uuid);

        if(array_key_exists('data', $data) && !empty($data['data']['id'])){
        Log::info($data['data']['id']);

            $gateway = app(PaymentGatewayRepositoryInterface::class);

            switch($data["type"]) {
                case "payment":
                    $payment = $gateway->showPayment($data['data']['id']);
                    break;
                case "plan":
                    $payment = $gateway->showPayment($data['data']['id']);
                    break;
                case "subscription":
                    $payment = $gateway->showPayment($data['data']['id']);
                    break;
                case "invoice":
                    $payment = $gateway->showPayment($data['data']['id']);
                    break;
                case "point_integration_wh":
                    // $_POST contém as informações relacionadas à notificação.
                break;
            }
        }
        // return new PaymentIntentionResource($this->paymentIntentionRepository->show($uuid));
    }

    private function prepareDataStore(array $preferences, array $data) : array
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
                        $mercadoPagoRepository = app(PaymentGatewayRepositoryInterface::class);
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
            'uuid'              => DB::raw('gen_random_uuid()'),
            'payer_id'          => $payer?->id ?? null,
            'origen'            => empty($payer) ? '2' : '1',
            'total_amount'      => $data['totalAmount'],
            'preferences_id'    => $preferences['id'],
            'webhook'           => $data['webHook'],
            'url_callback'      => $data['urlCallback'],
            'gateway'           => $data['gateway'],
        );
    }

    private function prepareDataPreferences(array $data) : array
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
                        $mercadoPagoRepository = app(PaymentGatewayRepositoryInterface::class);
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
            "additional_info" => "Produto tese",
            "back_urls" => array(
                "success" => config("constants.APP_URL")."/success",
                "pending" => config("constants.APP_URL")."/pending",
                "failure" => config("constants.APP_URL")."/failure",
            ),
            "external_reference" => "vinicius.colde@gmail.com",
            "notification_url" => config("constants.APP_URL")."/api/v1/intentions/" . $data['uuid'] . "/webhook",
            "payment_methods"  => array(
                "excluded_payment_methods" => [[
                    "id" => 'visa'
                ]],
                // "excluded_payment_types" => [[
                //     "id" => 'visa',
                // ]],
                "installments" => 6,
            ),
            "items" => $data['items'],
            "payer" => array(
                "name" => $payer->first_name,
                "surname" => $payer->last_name,
                "email" => $payer->email,
                "phone" => array(
                    "area_code" => substr($payer->phone, 0, 2),
                    "number" => substr($payer->phone, 2, strlen($payer->phone)-2)
                ),
                "identification" => array(
                    "type" => strlen($payer->cnpjcpf) > 11 ? "CNPJ" : "CPF",
                    "number" => $payer->cnpjcpf,
                ),
                "address" => array(
                    "zip_code" => $payer->address->zip_code,
                    "street_name" => $payer->address->street_name,
                    "street_number" => $payer->address->street_number,
                ),
            ),
            "statement_descriptor" => "Loja Azul",
            "total_amount" => $data['totalAmount'],
        );
    }
}
