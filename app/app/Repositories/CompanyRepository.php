<?php

namespace App\Repositories;

use App\Models\Companies;
use App\Repositories\Contracts\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function store(array $data) : Companies {
        return Companies::create($data);
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : Companies {
        $companies = Companies::where('uuid', $uuid)->firstOrFail();

        return $companies->update($data);
    }

    public function showByUuid(string $uuid) : Companies {
       return Companies::where('uuid', $uuid)->firstOrFail();
    }
}
