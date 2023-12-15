<?php

namespace App\Repositories\Gateways;

use App\Classes\CustomRequest;
use App\Http\Resources\PayerResource;
use App\Models\CustomersMercadoPago;
use App\Models\GatewayMercadoPago;
use App\Repositories\Contracts\Gateways\PaymentGatewayRepositoryInterface;
use App\Repositories\Contracts\PayerRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MercadoPagoRepository implements PaymentGatewayRepositoryInterface
{
    private GatewayMercadoPago $mercadoPago;

    public function __construct()
    {
        $this->mercadoPago = Auth::user()->company->mercadoPago;

        if(!empty($this->mercadoPago))
        {
            $date = new Carbon();
            if($this->mercadoPago->expires_in_at <= $date)
            {
                $data['grantType'] = "refresh_token";
                $data['refreshToken'] = $this->mercadoPago->refresh_token;
                $this->auth($data);

                $this->mercadoPago = Auth::user()->company->mercadoPago;
            }
        }
    }

    public function auth(array $data) : array
    {
        Log::info("MercadoPagoRepository@auth");

        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/oauth/token");
        $req->setHeaders(["Content-Type" => "application/json"]);
        $req->setBody([
            "redirect_uri" =>   env("APP_URL"),
            "client_secret" =>  config("constants.CLIENT_SECRET_MP"),
            "client_id" =>      config("constants.CLIENT_ID_MP"),
            "grant_type" =>     $data["grantType"],
            "code" =>           $data["code"],
            "refresh_token" =>  $data["refreshToken"],
        ]);

        if($req->post() && in_array($req->response->getCode(), [201, 200]))
        {
            Log::info(json_encode($req->response->getAsString()));
            Auth::user()->company->mercadoPago()->create($this->prepareDataAuth($req->response->getAsJson()))->refresh();
            return $req->response->getAsJson();
        }
        else
        {
            Log::info(json_encode($req->response->asString));
            throw new Exception("Error get Token auth");
        }
    }

    public function createPreferences(array $data) : array
    {
        Log::info("MercadoPagoRepository@createPreferences");

        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/checkout/preferences");
        $req->setHeaders([
            "Content-Type" => "application/json",
            "Authorization" =>  "Bearer " . $this->mercadoPago->access_token,
            "x-integrator-id" =>  config('constants.X_INTEGRATOR_ID'),
        ])
        ->setBody(json_encode($data));

        if($req->post() && $req->response->getCode() == 201)
        {
            Log::info(json_encode($req->response->getAsString()));
            return json_decode(json_encode($req->response->getAsJson()), true);
        }
        else
        {
            Log::info(json_encode($req->response->getAsString()));
            throw new Exception("Error get Token auth");
        }
    }

    public function showPayment(string $uuid) : array
    {
        Log::info("MercadoPagoRepository@createPreferences");

        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL") . "/v1/payments" . $uuid);
        $req->setHeaders([
            "Content-Type" => "application/json",
            "Authorization" =>  "Bearer " . $this->mercadoPago->access_token,
        ]);

        if($req->get() && $req->response->getCode() == 200)
        {
            Log::info(json_encode($req->response->getAsString()));
            return json_decode(json_encode($req->response->getAsJson()), true);
        }
        else
        {
            Log::info(json_encode($req->response->getAsString()));
            throw new Exception("Error get Token auth");
        }
    }

    public function createPayment(array $data) : array
    {
        Log::info("MercadoPagoRepository@createPayment");

        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/v1/payments");
        $req->setHeaders([
            "Content-Type" => "application/json",
            "Authorization" =>  "Bearer " . $this->mercadoPago->access_token,
            "X-Idempotency-Key" =>  $data['external_reference'],
        ])
        ->setBody(json_encode($data));

        if($req->post() && in_array($req->response->getCode(), [201, 200]))
        {
            Log::info(json_encode($req->response->getAsString()));
            return json_decode(json_encode($req->response->getAsJson()), true);
        }
        else
        {
            Log::info(json_encode($req->response->getAsString()));
            throw new Exception("Error get Token auth");
        }
    }

    public function showByEmailPayer(string $email) : array
    {
        Log::info("MercadoPagoRepository@showByEmailPayer");

        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/v1/customers/search?email=" . $email);
        $req->setHeaders([
            "Content-Type" => "application/json",
            "Authorization" =>  "Bearer " . $this->mercadoPago->access_token,
        ]);

        if($req->get() && in_array($req->response->getCode(), [200]) && $req->response->getAsJson()->paging->total > 0)
        {
            Log::info($req->response->getAsString());
            return json_decode(json_encode($req->response->getAsJson()->results[0]), true);
        }
        else
        {
            Log::info(json_encode($req->response->getAsString()));
            Log::info(json_encode($req->response->getCode()));
            return [];
        }
    }

    public function createPayer(PayerResource $data) : CustomersMercadoPago
    {
        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/v1/customers");
        $req->setHeaders([
            "Content-Type" => "application/json",
            "Authorization" =>  "Bearer " . $this->mercadoPago->access_token,
        ]);
        $req->setBody(json_encode($this->prepareDataCreatePayer($data)));

        if($req->post() && in_array($req->response->getCode(), [201, 200]))
        {
            Log::info(json_encode($req->response->getAsString()));
            return $this->savePayerToDB($data['uuid'], json_decode(json_encode($req->response->getAsJson()), true));
        }
        else
        {
            Log::info(json_encode($req->response->getAsString()));
            throw new Exception("Error when creating payer");
        }
    }

    public function savePayerToDB(string $uuid, array $data) : CustomersMercadoPago
    {
        $payerRepository = app(PayerRepositoryInterface::class);
        $payer = $payerRepository->show($uuid);
        return $payer->mercadoPago()->create(['gateway_customer_id' => $data['id']])->refresh();
    }

    private function prepareDataAuth(array $data){
        $date = new Carbon();
        return array(
            "user_id" =>        $data["user_id"],
            "access_token" =>   $data["access_token"],
            "public_key" =>     $data["public_key"],
            "refresh_token" =>  $data["refresh_token"],
            "expires_in_at" =>  $date->addSeconds($data["expires_in"]),
        );
    }

    private function prepareDataCreatePayer(PayerResource $data){
        $date = Carbon::now()->toIso8601String();
        return array(
            "address" => [
                "id" => $data->address->id,
                "zip_code" => $data->address->zip_code,
                "street_name" => $data->address->street_name,
                "street_number" => $data->address->street_number,
                "city" => [
                    "name" => $data->address->city,
                ],
            ],

            "date_registered" => $date,

            "email" => $data->email,
            "first_name"=> $data->first_name,
            "last_name"=> $data->last_name,
            // "phone" => [
            //   "area_code" => $data->email,
            //   "number" => $data->email,
            // ],

            "identification" => [
                "type" => Strlen($data->cnpjcpf) > 11 ? "CNPJ" : "CPF",
                "number" => $data->cnpjcpf,
            ],
            "description" => $data->first_name . " " . $data->last_name,
        );
    }
}
