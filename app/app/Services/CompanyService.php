<?php

namespace App\Services;

use App\Http\Resources\CompanyResource;
use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CompanyService
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        return CompanyResource::collection($this->companyRepository->index());
    }

    public function store(array $data) : CompanyResource {
        return new CompanyResource($this->companyRepository->store($this->prepareDataStore($data)));
    }

    public function update(string $uuid, array $data) : CompanyResource {
        return new CompanyResource($this->companyRepository->update($uuid, $this->prepareDataUpdate($data)));
    }

    public function show(string $uuid) : CompanyResource {
        return new CompanyResource($this->companyRepository->show($uuid));
    }

    private function prepareDataStore(array $data) : array
    {
        return array(
            'uuid'          => (string) Uuid::uuid4(),
            'email'         => $data['email'],
            'cnpjcpf'       => $data['cnpjCpf'],
            'business_name' => $data['businessName'],
        );
    }

    private function prepareDataUpdate(array $data) : array
    {
        $newData = [];

        if(array_key_exists('businessName', $data))
            $newData['business_name'] = $data['businessName'];

        if(array_key_exists('email', $data))
            $newData['email'] = $data['email'];

        return $newData;
    }
}
