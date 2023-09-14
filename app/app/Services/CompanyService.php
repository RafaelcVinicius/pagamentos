<?php

namespace App\Services;

use App\Http\Resources\CompanyResource;
use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\CompanyRepositoryInterface;

class CompanyService
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function store(array $data) : CompanyResource {
        return new CompanyResource($this->companyRepository->store($data));
    }

    public function show() : array {
        return [];
    }

    public function update(array $data, string $uuid) : CompanyResource {
        return new CompanyResource($this->companyRepository->update($data, $uuid));
    }

    public function showByUuid(string $uuid) : CompanyResource {
        return new CompanyResource($this->companyRepository->showByUuid($uuid));
    }
}
