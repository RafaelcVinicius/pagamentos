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

    public function index(Request $request) {
        return $this->paymentService->index();
    }

    public function update(StoreRequest $request, string $uuid) {
        return $this->paymentService->update($request->validated(), $uuid);

    }

    public function show(Request $request, string $uuid) {
        return $this->paymentService->show($request, $uuid);
    }

    public function webhook(Request $request, string $uuid) {
        return $this->paymentService->webhook($request->all(), $uuid);
    }
}
