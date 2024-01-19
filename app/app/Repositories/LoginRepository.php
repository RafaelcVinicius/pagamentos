<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\LoginRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginRepository implements LoginRepositoryInterface
{
    public function createUser(array $data) : bool
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->bearerToken(),
            'Content-Type' => "application/json",
        ])->post(config("constants.APP_AUTH") . "/admin/realms/" . config('constants.REALME') . "/users", $data);
dd( $response);
        if(!$response->created()){
            $message = !empty($response->body()) ? array_values(json_decode($response->body(), true))[0] : "";
            throw new Exception($message, $response->status());
        }

        return $this->createUserDB($data);
    }

    public function token(array $data) {
        $response = Http::asForm()->post(config("constants.APP_AUTH") . "/realms/" . config('constants.REALME') . "/protocol/openid-connect/token", $data);

        if(!$response->ok()){
            $message = !empty($response->body()) ? array_values(json_decode($response->body(), true))[0] : "";
            throw new Exception($message, $response->status());
        }

        return json_decode($response->body(), true);
    }

    public function logout(array $data) {
        $response = Http::asForm()->post(config("constants.APP_AUTH") . "/realms/" . config('constants.REALME') . "/protocol/openid-connect/logout", $data);

        if(!($response->ok() || $response->notFound())){
            $message = !empty($response->body()) ? array_values(json_decode($response->body(), true))[0] : "";
            throw new Exception($message, $response->status());
        }

        return true;
    }

    public function show(){
        return Auth::user();
    }

    private function bearerToken() : string {
        $response = Http::asForm()->post(config("constants.APP_AUTH") . "/realms/" . config('constants.REALME') . "/protocol/openid-connect/token", [
            "client_id" => env('CLIENT_ID'),
            "client_secret" => env('CLIENT_SECRET'),
            "grant_type" => "client_credentials",
        ]);

        if(!$response->ok()){
            $message = !empty($response->body()) ? array_values(json_decode($response->body(), true))[0] : "";
            throw new Exception($message, $response->status());
        }

        return json_decode($response->body(), true)['access_token'];
    }

    private function createUserDB(array $data) : bool {
        dd( $data);
        $user = new User();
        $user->uuid =       DB::raw('gen_random_uuid()');
        $user->name =       $data['username'];
        $user->email =      $data['email'];
        $user->password =   $data['credentials'][0]['value'];

        return $user->save();
    }
}
