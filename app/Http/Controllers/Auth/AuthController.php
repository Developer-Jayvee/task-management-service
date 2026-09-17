<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $_authService
    ) {}

    public function signIn(SignInRequest $request)
    {
        return $this->_authService->signIn(
            email : $request->validated('email'),
            password : $request->validated('password')
        );
    }

    public function signOut(Request $request) 
    {
        return $this->_authService->signOut();
    }

    public function signUp(SignUpRequest $request)
    {
        
        return $this->_authService->signUp(
            data : $request->all()
        );
    }

}
