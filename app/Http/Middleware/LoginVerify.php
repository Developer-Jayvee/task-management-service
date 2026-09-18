<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class LoginVerify
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('auth-token');
        if(!$token) {
            return $this->successResponse(
                message: "Unauthenticated",
                code: 401
            );
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if(! $accessToken) {
            return $this->successResponse(
                message: "Unauthenticated",
                code: 401
            );
        }
        
       $user = $accessToken->tokenable;

        $user->withAccessToken($accessToken);

        Auth::setUser($user);
        return $next($request);
    }
}
