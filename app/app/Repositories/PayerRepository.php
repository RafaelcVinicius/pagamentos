<?php

namespace App\Repositories;

use App\Models\Payers;
use App\Repositories\Contracts\PayerRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PayerRepository implements PayerRepositoryInterface
{
    public function store(array $data) : Payers {
        dd(Auth::user()->companies->payers->first());

        return Auth::user()->companies->payers()->create($data)->refresh();
    }

    public function index() : array {
        return Auth::user()->companies->payers()->all();
    }

    public function update(string $uuid, array $data) : Payers {
        $companies = Auth::user()->companies->payers->where('uuid', $uuid)->firstOrFail();

        return $companies->update($data);
    }

    public function show(string $uuid) : Payers {
       return Auth::user()->companies->payers->where('uuid', $uuid)->firstOrFail();
    }
}
