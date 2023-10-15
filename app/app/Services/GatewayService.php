<?php

namespace App\Services;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\GatewayResource;
use App\Repositories\Contracts\GatewayRepositoryInterface;
use App\Repositories\GatewayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GatewayService
{
    private GatewayRepository $GatewayRepository;

    public function __construct(GatewayRepositoryInterface $GatewayRepository)
    {
        $this->GatewayRepository = $GatewayRepository;
    }

    public function index()
    {
        return GatewayResource::collection($this->GatewayRepository->index());
    }

    public function store(array $data) : GatewayResource {
        return new GatewayResource($this->GatewayRepository->store($this->prepareDataStore($data)));
    }

    public function update(string $uuid, array $data) : GatewayResource {
        return new GatewayResource($this->GatewayRepository->update($uuid, $data));
    }

    public function show(string $type) : GatewayResource {
        return new GatewayResource($this->GatewayRepository->show($type));
    }

    private function prepareDataStore(array $data) : array
    {
        return array(
            "mercadoPago" => array(
                "code"          => $data['mercadoPago']['code'],
                "grantType"          => "authorization_code",
            ),
        );
    }
}
