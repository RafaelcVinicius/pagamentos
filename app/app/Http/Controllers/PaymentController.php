<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StoreRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(StoreRequest $request) {
        return  $this->paymentService->store($request->validated());
    }

    public function show(Request $request) : array {
        return $this->paymentService->show();
    }

    public function update(StoreRequest $request, $uuid) {
        return $this->paymentService->update($request->validated(), $uuid);

    }

    public function showByUuid(Request $request, $uuid) {
        return $this->paymentService->showByUuid($uuid);
    }
}
