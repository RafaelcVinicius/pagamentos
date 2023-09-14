<?php

namespace App\Repositories\Contracts;

interface CompanyRepositoryInterface
{
    public function showApiBcbSgs($code, $format = null);
}
