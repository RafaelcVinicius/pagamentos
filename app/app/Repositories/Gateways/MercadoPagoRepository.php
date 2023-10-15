<?php

namespace App\Repositories\Gateways;

use App\Classes\CustomRequest;
use App\Models\Companies;
use App\Repositories\Contracts\Gateways\MercadoPagoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MercadoPagoRepository implements MercadoPagoRepositoryInterface
{
    public function auth (array $data) : array
    {
        $req = new CustomRequest();
        $req->setRoute(config("constants.API_MP_URL")."/oauth/token");
        $req->setHeaders(["Content-Type" => "application/json"]);
        $req->setBody([
            "client_secret" =>  config("constants.CLIENT_SECRET_MP"),
            "client_id" =>      config("constants.CLIENT_ID_MP"),
            "grant_type" =>     $data["grantType"],
            "code" =>           $data["code"]
        ]);

        if($req->post() && in_array($req->code, [201, 200])){
            Log::info(json_encode($req->asString));
            return $req->asJson;
        }
        else{
            Log::info(json_encode($req->asString));
            return [];
        }
    }

    public function store(array $data) : Companies
    {
        return Auth::user()->company()->create($data)->refresh();
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
}
