<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentIntention\UpdateRequest;
use App\Http\Requests\PaymentIntention\StoreRequest;
use App\Services\PaymentIntentionService;
use Illuminate\Http\Request;

class PaymentIntentionController extends Controller
{
    private PaymentIntentionService $paymentIntentionService;

    public function __construct(PaymentIntentionService $paymentIntentionService)
    {
        $this->paymentIntentionService = $paymentIntentionService;
    }

    public function store(StoreRequest $request) {
        return  $this->paymentIntentionService->store($request->validated());
    }

    public function index() {
        return $this->paymentIntentionService->index();
    }

    public function update(UpdateRequest $request, $uuid) {
        return $this->paymentIntentionService->update($request->validated(), $uuid);

    }

    public function show(Request $request, $uuid) {
        return $this->paymentIntentionService->show($uuid);
    }
}
