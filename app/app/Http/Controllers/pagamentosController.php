<?php

namespace App\Http\Controllers;

use App\Classes\CustomRequest;
use App\Models\Companies;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class pagamentosController extends Controller
{

    public function index(Request $request){
        return view('createCompany');
    }

    public function create(Request $request){

        $company = Companies::where("public_key", $request->get("publicKey"))->first();

        if($company == null)
        {
            $company = new Companies();
            $company->public_key = $request->get("publicKey");
        }

        $company->access_token = $request->get("accessToken");
        $company->save();

        return redirect()->route('payment', ['id' => $company->id]);
    }

    public function paymentByCompany(Request $request, $id){
        $company = Companies::where("id", $id)->first();

        return view('payment')->with('company', $company);
    }

    public function show(Request $request, $id){

        $company = Companies::where("id", $id)->first();
        return view("showPayment")->with('payments',  $company->payments);
    }

    public function createPagamento(Request $request){

        $company = Companies::where("public_key", $request->get("publicKey"))->first();

        $payment = new Payments();
        $payment->transaction_amount = 0.51;
        $payment->company_id = $company->id;

        $obj["transaction_amount"] = 0.51;
        $obj["payment_method_id"] = $request->get("paymentMethodId");
        $obj["issuer_id"] = $request->get("issuerId");
        $obj["token"] = $request->get("token");
        $obj["installments"] = $request->get("installments");
        $obj["payer"] = [
            "type" => "customer",
            "first_name" => "rafael",
            "email" => $request->get("email"),
            "identification" => [
                "type" => $request->get("identificationType"),
                "number" => $request->get("identificationNumber"),
            ],
        ];

        $obj["additional_info"] = [
            "payer" => [
                "first_name" => "Cliente",
                "last_name" => "Padrão",
                "phone" => [
                    "area_code" => 49,
                    "number" => "34420022",
                ],
            ],
            "shipments" => [
                "receiver_address" => [
                    "zip_code" => "89700-001",
                    "state_name" => "Santa Catarina",
                    "city_name" => "Concórdia",
                    "street_name" => "R. Dr. Maruri",
                    "street_number" => 990,
                ],
            ],
        ];

        $obj["additional_info"]["items"] = [
            "0" => [
                "id" => "SGBR1000",
                "title" => "Ede Ramo",
                "description" => "Producto Ede para Ramos bluetooth",
                "category_id" => "electronics",
                "quantity" => 1,
                "unit_price" => 0.51,
            ]
        ];

        Log::info(json_encode($obj));

        Log::info(1);

        Log::info("CustomRequest");
        $req = new CustomRequest();
        $req->setRoute('https://api.mercadopago.com/v1/payments');
        $req->setHeaders([
            'Content-Type' =>  'application/json',
            'Authorization' => 'Bearer ' . $company->access_token,
        ]);
        $req->setbody(json_encode($obj));
        Log::info("post");
        $req->post();
        Log::info("fim");

        Log::info(json_encode($req));


        if($req->response->code == 201){
            $payment->payments_id = $req->response->asJson?->id;
            $payment->status = $req->response->asJson?->status_detail;
            $payment->date_created = $req->response->asJson?->date_created;
            $payment->save();

            return response()->json([], 201);
        }
        else{
            return response()->json([
                "message" => $req->response->asJson?->message,
                "cause" => $req->response->asJson?->cause,
            ], 200);
        }
    }
}
