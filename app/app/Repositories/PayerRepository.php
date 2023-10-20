<?php

namespace App\Repositories;

use App\Models\Payers;
use App\Repositories\Contracts\PayerRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PayerRepository implements PayerRepositoryInterface
{
    public function store(array $data) : Payers {
        $payers = Auth::user()->company->payers()->create($data)->refresh();
        $payers->address()->create($data['address']);
        return $payers->refresh();
    }

    public function index() {
        return Auth::user()->company->payers()->get();
    }

    public function update(string $uuid, array $data) : Payers {
        $payer = Auth::user()->company->payers->where('uuid', $uuid)->firstOrFail();
        $payer->update($data);

        return $payer->refresh();
    }

    public function show(string $uuid) : Payers {
       return Auth::user()->company->payers->where('uuid', $uuid)->firstOrFail();
    }
}
