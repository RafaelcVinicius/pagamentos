<?php

namespace App\Http\Middleware;

use App\Models\Payments;
use App\Models\PaymentsIntention;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KeycloakAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // Assumindo que o token está no cabeçalho de autorização

        try {
            if(!$token){
                if(str_contains($request->route()->uri, 'api/v1/intentions') && $request->route('intentionUuid'))
                {
                    $paymentsIntention = PaymentsIntention::where('uuid', $request->route('intentionUuid'))->firstOrFail();
                    $user =  $paymentsIntention->company->user;
                }
                else if(str_contains($request->route()->uri, 'api/v1/payments') && $request->method() == "POST" && $request->route('paymentUuid'))
                {
                    $payments = Payments::where('uuid', $request->route('paymentUuid'))->firstOrFail();
                    $user =  $payments->paymentIntention->company->user;
                }
                else if(!(str_contains($request->route()->uri, 'api/v1/payments')))
                {
                    return response()->json(['message' => 'Token de acesso ausente!'], 401);
                }
                else
                {
                    $user = null;
                }
            }
            else
            {
                $publicKey = <<<EOD
                    -----BEGIN PUBLIC KEY-----
                    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxEuUpZlWvTU4xYY19y/SmpMMnPBmyE9KnvEtOiZN/UWM5krqh9CuIAvUplw1i8im7HRPW1Xz+YJRYAz72JVqxzNLxB0VAVjtlJFZ/M4R81MbKtMuk1U1WLC2wAiwyBsP+uI2HLERef0VdFCexrgGPi6jEvJjoAntZQzoL0Sfbp72u6IsGo9mFm8GWz1nwM1LvP/PJR8/w62lno9GEBeFCwAZQMS/A739UnxT7IpoI/JBXlYB79x/5sPG9jYQV8S4N1MwqA6tC2/lVaZyta5GheXPcTrc2rQ+shjYrPF9S7UQLZZWBE9ltgKFUJ8MI+Uf9CstBVP7kWG0t/SQbNutmQIDAQAB
                    -----END PUBLIC KEY-----
                    EOD;

                $decodedToken = JWT::decode($token, new Key($publicKey, 'RS256'));

                $user = User::where('uuid', $decodedToken->sub)->first();

                if(!$user){
                    $user = new User();
                    $user->uuid     = $decodedToken->sub;
                    $user->email    = $decodedToken->email;
                    $user->name     = $decodedToken->name;
                    $user->password = $decodedToken->sub;
                    $user->save();
                    $user->refresh();
                }
            }

            if($user)
                Auth::attempt(['email' => $user->email, 'password' =>  $user->uuid]);

            return $next($request);
        } catch (\Exception) {
            return response()->json(['message' => 'Token de acesso inválido'], 401);
        }
    }
}
