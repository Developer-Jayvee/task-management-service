<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\UpdateResetPasswordRequest;
use App\Models\User;
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
        return $this->_authService->signOut($request);
    }

    public function signUp(SignUpRequest $request)
    {

        return $this->_authService->signUp(
            data : $request->all()
        );
    }

    public function resetPassword(UpdateResetPasswordRequest $request) 
    {
        $this->authorize('resetPassword',$request->user());

        return $this->_authService->resetPassword(
            email: $request->input('email')
        );
    }

    public function resetPasswordLink(ResetPasswordRequest $request)
    {
         return $this->_authService->resetPasswordLink($request);
    }
}
