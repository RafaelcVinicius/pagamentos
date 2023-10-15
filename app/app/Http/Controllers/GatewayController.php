<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gateway\StoreRequest;
use App\Services\GatewayService;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    private GatewayService $gatewayService;

    public function __construct(GatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    public function store(StoreRequest $request){
        return  $this->gatewayService->store($request->validated());
    }

    public function index(Request $request) {
        return $this->gatewayService->index();
    }

    public function update(StoreRequest $request, $uuid) {
        return $this->gatewayService->update($request->validated(), $uuid);
    }

    public function show(Request $request, $uuid) {
        return $this->gatewayService->show($uuid);
    }
}
