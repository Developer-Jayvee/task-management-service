<?php

namespace App\Services\Auth;

use App\Enums\Roles;
use App\Models\Member;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Queue\InvalidPayloadException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Support\Str;


class AuthService
{
    use ResponseTrait;
    
    public function signIn( string $email, string $password ) 
    {
        try {
            if(!Auth::attempt([
                'email' => $email,
                'password' => $password
            ])) {
                throw new UnauthorizedException("Email or Password is incorrect",401);
            }
            request()->session()->regenerate();

            return $this->successResponse(
                [
                    'tenant' => request()->user()?->tenant
                ],
                "Successfully login"
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function signOut()
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return $this->successResponse(null,"Successfully logout");
    } 

    public function signUp(array $data) 
    {
        try {
            if($data['password'] !== $data['cpassword']) {
                throw new \Exception("Password do not match", 422);
            }

            $slug = Str::of($data['company'])->slug('-');
            
            $tenant = Tenant::query()->tenant($slug)->exists();
    
            if(!$tenant) {
                throw new \Exception("Company does not exist", 422);
            }
    
            DB::transaction(function ()  use($data , $slug) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                $tenant = Tenant::query()->where('name',$data['company'])->first();
                $isOwner = false;
                
                if(! $tenant) {
                    $tenant = Tenant::create([
                        'name' => $data['company'],
                        'slug' => $slug,
                        'plan' => 'pro'
                    ]);
                    $isOwner = true;
                }
    
                Member::create([
                    'user_id' => $user->id,
                    'tenant_id' => $tenant->id,
                    'role' => $isOwner ? Roles::OWNER : Roles::MEMBER
                ]);

                $user->assignRole(
                    $isOwner ? Roles::OWNER : Roles::MEMBER
                );
    
            });
    
            return $this->successResponse(null,"Successfully Register");
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }

    }
}
