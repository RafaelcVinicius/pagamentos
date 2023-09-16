<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StoreRequest;
use App\Http\Resources\PaymerResource;
use App\Services\PaymerService;
use Illuminate\Http\Request;

class PaymerController extends Controller
{
    private PaymerService $paymerService;

    public function __construct(PaymerService $paymerService)
    {
        $this->paymerService = $paymerService;
    }

    public function store(StoreRequest $request) : PaymerResource {
        return  $this->paymerService->store($request->validated());
    }

    public function show(Request $request) : array {
        return $this->paymerService->show();
    }

    public function update(StoreRequest $request, $uuid) : PaymerResource {
        return $this->paymerService->update($request->validated(), $uuid);

    }

    public function showByUuid(Request $request, $uuid) : PaymerResource {
        return $this->paymerService->showByUuid($uuid);
    }
}
