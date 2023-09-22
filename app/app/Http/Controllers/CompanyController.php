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

    public function index() {
        return $this->companyService->index();
    }

    public function update(StoreRequest $request) : CompanyResource {
        return $this->companyService->update($request->route('companyUuid'), $request->validated());

    }

    public function show(Request $request) : CompanyResource {
        return $this->companyService->show($request->route('companyUuid'));
    }
}
