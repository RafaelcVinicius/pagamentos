<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface LoginRepositoryInterface
{
    public function createUser(array $data) : bool;
    public function token(array $data);
    public function logout(array $data);
    public function show();
}
