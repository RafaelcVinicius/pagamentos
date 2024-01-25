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

class KeycloakAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        try {
            if (!$token) {

                if (str_contains($request->route()->uri, 'api/v1/intentions') && $request->route('intentionUuid')) {
                    $paymentsIntention = PaymentsIntention::where('uuid', $request->route('intentionUuid'))->firstOrFail();
                    $user =  $paymentsIntention->company->user;
                } else if (str_contains($request->route()->uri, 'api/v1/payments') && $request->method() == "POST" && $request->route('paymentUuid')) {
                    $payments = Payments::where('uuid', $request->route('paymentUuid'))->firstOrFail();
                    $user =  $payments->paymentIntention->company->user;
                } else if (str_contains($request->route()->uri, 'api/v1/payments') && $request->method() == "POST") {
                    $paymentsIntention = PaymentsIntention::where('uuid', $request->get('paymentIntentionUuid'))->firstOrFail();
                    $user =  $paymentsIntention->company->user;
                } else {
                    return response()->json(['message' => 'Token de acesso ausente!'], 401);
                }
            } else {
                $publicKey = <<<EOD
                    -----BEGIN PUBLIC KEY-----
                    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvwvpqGmphmPooNnfCU3QyfkdCM4+UwNxC+hVUxiBYkFBP4szJ3DtDM3twqc+4inUIlh+h96tyhL+C2KaWXj5xvGO9tUxgPjtRmvqUKDckdULMdb5Y9Ke86OQPlj4jqpMp1Ifs5M6rYbWreSXuGud24ey5Jc/w9K2t5nHMwAf5FLSh6Wpu62fQK3xQnaQnosFpmzo9G5X46/qfxUZliPKmnyrDtBbEeFnOnzlI2JRdG98XH9oNyFzYXrUYsaRRwpOVNwSeNxSpqxFzXwLuZUIN1tqDU/WWgtS7ML5ZxvUq0I2bLxf6iUHttagmdhdnnw7/05PYcDhnVpVGuCacQ/i8wIDAQAB
                    -----END PUBLIC KEY-----
                    EOD;

                $decodedToken = JWT::decode($token, new Key($publicKey, 'RS256'));

                $user = User::where('email', $decodedToken->email)->firstOrFail();
            }

            Auth::loginUsingId($user->id);

            return $next($request);
        } catch (\Exception) {
            return response()->json(['message' => 'Token de acesso inválido'], 401);
        }
    }
}
