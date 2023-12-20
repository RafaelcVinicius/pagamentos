<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\CreateRequest;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Login\LogoutRequest;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function register(CreateRequest $request)
    {
        return  $this->loginService->register($request->validated());
    }

    public function token(LoginRequest $request)
    {
        return  $this->loginService->token($request->validated());
    }

    public function logout(LogoutRequest $request)
    {
        return  $this->loginService->logout($request->validated());
    }

    public function show()
    {
        return  $this->loginService->show();
    }
}
