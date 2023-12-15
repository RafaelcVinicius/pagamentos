<?php

namespace App\Services;

use App\Http\Resources\PayerCollection;
use App\Http\Resources\PayerResource;
use App\Repositories\Contracts\PayerRepositoryInterface;
use App\Repositories\PayerRepository;
use Illuminate\Support\Facades\DB;

class PayerService
{
    private PayerRepository $payerRepository;

    public function __construct(PayerRepositoryInterface $payerRepository)
    {
        $this->payerRepository = $payerRepository;
    }

    public function store(array $data) : PayerResource {
        return new PayerResource($this->payerRepository->store($this->prepareDataStore($data)));
    }

    public function index() : PayerCollection {
        return new PayerCollection($this->payerRepository->index());
    }

    public function update(string $uuid, array $data) : PayerResource {
        return new PayerResource($this->payerRepository->update($uuid, $this->prepareDataUpdate($data)));
    }

    public function show(string $uuid) : PayerResource {
        return new PayerResource($this->payerRepository->show($uuid));
    }

    private function prepareDataStore(array $data) : array
    {
        return array(
            'uuid'          => DB::raw('gen_random_uuid()'),
            'first_name'    => $data['firstName'],
            'last_name'     => $data['lastName'],
            'email'         => $data['email'],
            'cnpjcpf'       => $data['cnpjCpf'],
            'phone'         => $data['phone'],
            "address" =>    [
                "zip_code" =>       $data['address']['zipCode'],
                "street_name" =>    $data['address']['streetName'],
                "street_number" =>  $data['address']['streetNumber'],
                "city" =>           $data['address']['city'],
            ],
        );
    }

    private function prepareDataUpdate(array $data) : array
    {
        $newData = [];

        if(array_key_exists('firstName', $data))
            $newData['first_name'] = $data['firstName'];

        if(array_key_exists('lastName', $data))
            $newData['last_name'] = $data['lastName'];

        if(array_key_exists('email', $data))
            $newData['email'] = $data['email'];

        if(array_key_exists('cnpjCpf', $data))
            $newData['cnpjcpf'] = $data['cnpjCpf'];

        return $newData;
    }
}
