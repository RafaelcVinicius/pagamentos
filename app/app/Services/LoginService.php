<?php

namespace App\Services;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\LoginRepositoryInterface;
use App\Repositories\LoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class LoginService
{
    private LoginRepository $loginRepository;

    public function __construct(LoginRepositoryInterface $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function register(array $data) : TokenResource {
        $user = $this->prepareDataCreateUser($data);
        if($this->loginRepository->createUser($user))

        $login = [
            "client_id" => env('CLIENT_ID'),
            "client_secret" => env('CLIENT_SECRET'),
            "username" => $user['email'],
            "password" => $user['credentials'][0]['value'],
            "grant_type" => "password",
        ];

        return new TokenResource($this->loginRepository->token($login));
    }

    public function token(array $data) : TokenResource {
        return new TokenResource($this->loginRepository->token($this->prepareDataToken($data)));
    }

    public function logout(array $data) {
        return $this->loginRepository->logout($this->prepareDataLogout($data));
    }

    public function show() {
        return new UserResource($this->loginRepository->show());
    }

    private function prepareDataCreateUser(array $data) : array {
        return array(
        "username" => $data['userName'],
        "firstName" => $data['userName'],
        "enabled" => true,
        "email" => $data['email'],
        "credentials" =>  [[
                "type" => "password",
                "value" => $data['password'],
                "temporary" => false
            ]]
        );
    }

    private function prepareDataToken(array $data) : array {
        if($data['grantType'] == 'authorization_code'){
            return array(
                "grant_type" =>     'password',
                "client_id" =>      env('CLIENT_ID'),
                "client_secret" =>  env('CLIENT_SECRET'),
                "username" =>       $data['email'],
                "password" =>       $data['password'],
            );
        }
        else{
            return array(
                "grant_type" =>     'refresh_token',
                "client_id" =>      env('CLIENT_ID'),
                "client_secret" =>  env('CLIENT_SECRET'),
                "refresh_token" =>  $data['refreshToken'],
            );
        }
    }

    private function prepareDataLogout(array $data) : array {
        return array(
            "refresh_token" =>   $data['refreshToken'],
            "client_id" =>      env('CLIENT_ID'),
            "client_secret" =>  env('CLIENT_SECRET'),
        );
    }
}
