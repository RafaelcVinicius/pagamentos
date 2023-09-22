<?php

namespace App\Repositories;

use App\Models\Companies;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function store(array $data) : Companies
    {
        return Auth::user()->companies()->create($data);
    }

    public function index() : array
    {
        return Auth::user()->companies->all();
    }

    public function update(string $uuid, array $data) : Companies
    {
        $companies = Auth::user()->companies->where('uuid', $uuid)->firstOrFail();
        $companies->update($data);

        return $companies->refresh();
    }

    public function show(string $uuid) : Companies
    {
       return Auth::user()->companies->where('uuid', $uuid)->firstOrFail();
    }
}
