<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreRequest;
use App\Http\Resources\CompanyResource;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function store(StoreRequest $request) : CompanyResource {
        return  $this->companyService->store($request->validated());
    }

    public function show(Request $request) : array {
        return $this->companyService->show();
    }

    public function update(StoreRequest $request, $uuid) : CompanyResource {
        return $this->companyService->update($request->validated(), $uuid);

    }

    public function showByUuid(Request $request, $uuid) : CompanyResource {
        return $this->companyService->showByUuid($uuid);
    }
}
