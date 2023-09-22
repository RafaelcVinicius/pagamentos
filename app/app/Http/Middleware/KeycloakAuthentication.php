<?php

namespace App\Http\Middleware;

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
        Log::info("inicio");

        $token = $request->bearerToken(); // Assumindo que o token está no cabeçalho de autorização

        if (!$token) {
            return response()->json(['message' => 'Token de acesso ausente'], 401);
        }

        try {
            // $publicKey = <<<EOD
            //     -----BEGIN PUBLIC KEY-----
            //     MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1RW4tF4o0SY+cfGa/jTU1JwA3qgTArLMHE7vFyNXCXiwl2BSlMhmgfNwFYaffQ5k7kZLe2rdTDsz7Bs32F2ONxYZTOhodsnuR1QWb+o8vnpIvKvoNEq6Lcd6mDqD+CYDJLHFI29QW7Amw0owtgNiiGYhqyDnDhSKC9aDdD5CH32epoKc9f6tjCAZvC/pZqCSRvi9AtATJ5UBCH/ZVZyZJlTfPA0ZdfZVEDnOGjS5cRmP5Tc8PKt5NgP0PZPguwQdKnHwukoceUewFQuat7HYcU9tAPJsXfFn9GnlBf2H8nQ7oLn4sQ2CBlGgQLH2TwIyhvIBC1AEiYxvsm/pPE+qtwIDAQAB
            //     -----END PUBLIC KEY-----
            //     EOD;

            // $decodedToken = JWT::decode($token, new Key($publicKey, 'RS256'));

            // $user = User::where('uuid', $decodedToken->sub)->first();
            $user = User::first();

            // if(!$user){
            //     $user = new User();
            //     $user->uuid     = $decodedToken->sub;
            //     $user->email    = $decodedToken->email;
            //     $user->name     = $decodedToken->name;
            //     $user->password = $decodedToken->preferred_username;
            //     $user->save();
            //     $user->refresh();
            // }

            Auth::attempt(['email' => $user->email, 'password' =>  'rafael']);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token de acesso inválido'], 401);
        }
    }
}
