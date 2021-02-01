<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ApiTokenChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth_token = $request->header('authorization');
        // Verifico se esiste un token
        if(empty($auth_token)) {
            return response()->json([
                'success' => false,
                'error' => 'Api token mancante'
            ]);
        }
        //Salto "Bearer "
        $api_token = substr($auth_token, 7);
        //Verifico API Token su api_token
        $user = User::where('api_token', $api_token)->first();
        //Se l'utente non esiste restituisco un errore
        if(!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Api token errato'
            ]);
        }
        return $next($request);
    }
}
