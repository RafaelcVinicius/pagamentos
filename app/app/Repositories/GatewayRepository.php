<?php

namespace App\Repositories;

use App\Models\Companies;
use App\Repositories\Contracts\GatewayRepositoryInterface;
use App\Repositories\Contracts\Gateways\MercadoPagoRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GatewayRepository implements GatewayRepositoryInterface
{
    public function store(array $data) : Companies {
        if(array_key_exists('mercadoPago', $data))
        {
            $mercadoPagoRepository = app(MercadoPagoRepositoryInterface::class);
            $mercadoPagoRepository->auth($this->prepareBodyAuth($data["mercadoPago"]));
        }

        return Auth::user()->company;
    }

    public function index() {
        return Auth::user()->company->GatewayMercadoPago()->get();
    }

    public function update(string $uuid, array $data) : Companies {
        $mercadoPago = Auth::user()->company->mercadoPago->firstOrFail();
        $mercadoPago->update($data);

        return $mercadoPago->refresh();
    }

    public function show(string $type) : Companies {
       return Auth::user()->company->mercadoPago->firstOrFail();
    }

    private function prepareBodyAuth(array $data){
        return array(
            "client_secret" =>  config("constants.CLIENT_SECRET_MP"),
            "client_id" =>      config("constants.CLIENT_ID_MP"),
            "grant_type" =>     "authorization_code",
            "code" =>           $data["code"],
            "redirect_uri" =>   config("constants.APP_URL_ADM")."/success",
        );
    }
}
