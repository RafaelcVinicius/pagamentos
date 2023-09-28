<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payer\StoreRequest;
use App\Http\Resources\PayerResource;
use App\Services\PayerService;
use Illuminate\Http\Request;

class PayerController extends Controller
{
    private PayerService $payerService;

    public function __construct(PayerService $payerService)
    {
        $this->payerService = $payerService;
    }

    public function store(StoreRequest $request) : PayerResource {
        return  $this->payerService->store($request->validated());
    }

    public function index(Request $request){
        return $this->payerService->index();
    }

    public function update(StoreRequest $request, $uuid) : PayerResource {
        return $this->payerService->update($uuid, $request->validated());
    }

    public function show(Request $request, $uuid) : PayerResource {
        return $this->payerService->show($uuid);
    }
}
