<?php

namespace App\Services;

use App\Http\Resources\wallet\WalletListResource;
use App\Http\Resources\wallet\WalletResource;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class CompanyService
{
    private CompanyRepository $walletRepository;

    public function __construct(CompanyRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function store(array $data): WalletResource
    {
        // $data['user_uuid'] = Auth::user()->uuid;
        return new WalletResource($this->walletRepository->store($this->prepareToStore($data)));
    }

    public function show(string $userId): WalletResource
    {
        return new WalletResource($this->walletRepository->show($userId));
    }

    public function showAll()
    {
        return new WalletListResource($this->walletRepository->showAll());
    }

    public function update(Request $request)
    {

    }

    private function prepareToStore(array $data): array
    {
        $newData = [
            'wallet' => [
                'description' =>    $data['description'],
                'origin_id' =>      $data['originId'],
            ]
        ];

        if(array_key_exists('stockExchange', $data))
            $newData['stockExchange'] = $data['stockExchange'];

        if(array_key_exists('coins', $data))
            $newData['coins'] = $data['coins'];

        if(array_key_exists('corporateBonds', $data)){
            $newData['corporateBonds']['description'] =             $data['corporateBonds']['description'];
            $newData['corporateBonds']['reward_at'] =               $data['corporateBonds']['reward'];
            $newData['corporateBonds']['variavel_rate_type'] =      $data['corporateBonds']['variavelRateType'] ?? null;
            $newData['corporateBonds']['variavel_rate'] =           $data['corporateBonds']['variavelRate'] ?? null;
            $newData['corporateBonds']['flat_rate'] =               $data['corporateBonds']['flatRate'] ?? null;
        }

        foreach($data['transaction'] as $key => $transaction){
            $newData['transaction'][$key]['operation'] =        $transaction['operation'];
            $newData['transaction'][$key]['amount'] =           $transaction['amount'];
            $newData['transaction'][$key]['unit_price'] =       $transaction['unitPrice'];
            $newData['transaction'][$key]['acquisition_at'] =   $transaction['acquisition'];
        }

        return  $newData;
    }
}
