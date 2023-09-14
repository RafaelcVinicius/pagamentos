<?php

namespace App\Repositories;

use App\Classes\CustomRequest;
use App\Repositories\Contracts\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function showApiBcbSgs($code, $format = ''){
        $req = new CustomRequest;
        $req->setRoute(config('routesapi.bcb.sgs').$code.'/dados?formato=json/'.$format);
        $req->setHeaders([
            'Host'          =>  'api.bcb.gov.br',
            'User-Agent'    =>  'null',
            'Accept'        =>  '*/*',
        ]);

        if(($req->get()) && ($req->response->code == 200))
            return $req->response->asJson;
        else{
            return [
                'status'   => 'error',
                'message'  => 'Ocorreu um erro na api no bcb',
                'code'     =>  $req->response->code
            ];
        }
    }
}
