<?php

namespace App\Repositories;

use App\Models\Companies;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function store(array $data) : Companies
    {
        return Auth::user()->company()->create($data)->refresh();
    }

    public function index() : array
    {
        return Auth::user()->company->all();
    }

    public function update(string $uuid, array $data) : Companies
    {
        $company = Auth::user()->company->where('uuid', $uuid)->firstOrFail();
        $company->update($data);

        return $company->refresh();
    }

    public function show(string $uuid) : Companies
    {
       return Auth::user()->company->where('uuid', $uuid)->firstOrFail();
    }
}
