<?php

namespace App\Repositories\Gateways;

use App\Classes\CustomRequest;
use App\Http\Resources\PayerResource;
use App\Models\Companies;
use App\Models\GatewayMercadoPago;
use App\Repositories\Contracts\Gateways\MercadoPagoRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MercadoPagoRepository implements MercadoPagoRepositoryInterface
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

        if($req->post() && in_array($req->response->code(), [201, 200]))
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

    public function showByEmailPayer(string $email) : array
    {
        Log::info("MercadoPagoRepository@showByEmailPayer");

        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/v1/customers/search?email=" . $email);
        $req->setHeaders([
            "Content-Type" => "application/json",
            "Authorization" =>  "Bearer " . $this->mercadoPago->access_token,
        ]);

        if($req->get() && in_array($req->response->getCode(), [200]))
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

    public function createPayer(PayerResource $data) : array
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
            return $req->response->getAsJson();
        }
        else
        {
            Log::info(json_encode($req->response->getAsString()));
            throw new Exception("Error when creating payer");
        }
    }

    public function update(string $uuid, array $data) : Companies
    {
        $company = Auth::user()->company->where('uuid', $uuid)->firstOrFail();
        $company->update($data);

        return $company->refresh();
    }

    public function show(string $uuid) : Companies
    {
       return Auth::user()->company->where('uuid', $uuid)->firstOrFail();
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
            "address" =>        [
                "id" => $data->address->id,
                "zip_code" => $data->address->zipCode,
                "street_name" => $data->address->streetName,
                "street_number" => $data->address->streetNumber,
                "city" => [
                    "name" => $data->address->city,
                ],
            ],

            "date_registered" => $date,

            "email" => $data->email,
            "first_name"=> $data->firstName,
            "last_name"=> $data->lastName,
            // "phone" => [
            //   "area_code" => $data->email,
            //   "number" => $data->email,
            // ],

            "identification" => [
                "type" => Strlen($data->cnpjCpf) > 11 ? "CNPJ" : "CPF",
                "number" => $data->cnpjCpf,
            ],
            "description" => $data->firstName . " " . $data->lastName,
        );
    }
}