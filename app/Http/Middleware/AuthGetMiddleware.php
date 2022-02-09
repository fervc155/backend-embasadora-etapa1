<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Token;

class AuthGetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->route('token')??false;


        if(!$accessToken)
            return bad_request('Se requiere un token de acceso');


        $user = Token::check($accessToken);


        if ($user) {
            Auth::login($user);
            $request->user= $user;
            return $next($request);
        }
        return unauthorized('Token invalido');

    }
}
