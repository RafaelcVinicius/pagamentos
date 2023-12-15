<?php

namespace App\Repositories\Contracts\Gateways;

use App\Http\Resources\PayerResource;

interface PaymentGatewayRepositoryInterface
{
    public function auth(array $data);
    public function createPreferences(array $data);
    public function createPayment(array $data);
    public function createPayer(PayerResource $data);
    public function savePayerToDB(string $uuis, array $data);
    public function showByEmailPayer(string $email);
}
