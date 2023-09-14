<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gateway\StoreRequest;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    private GatewayService $gatewayService;

    public function __construct(GatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    public function store(StoreRequest $request) : GatewayResource {
        return  $this->gatewayService->store($request->validated());
    }

    public function show(Request $request) : array {
        return $this->gatewayService->show();
    }

    public function update(StoreRequest $request, $uuid) : GatewayResource {
        return $this->gatewayService->update($request->validated(), $uuid);

    }

    public function showByUuid(Request $request, $uuid) : GatewayResource {
        return $this->gatewayService->showByUuid($uuid);
    }
}
