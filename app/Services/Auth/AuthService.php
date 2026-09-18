<?php

namespace App\Services\Auth;

use App\Enums\Roles;
use App\Models\Member;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

class AuthService
{
    use ResponseTrait;

    public function signIn(string $email, string $password)
    {
        try {
            $user = User::query()->where('email', $email)->firstOrFail();

            if (! Hash::check($password, $user->password)) {
                throw new UnauthorizedException('Email or Password is incorrect', 401);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return $this->successResponse(
                [
                    'tenant' => $user?->tenant,
                ],
                'Successfully login'
            )
                ->withCookie(
                    cookie(
                        'auth-token',
                        $token,
                        6000,
                        '/',
                        null,
                        true,
                        true,
                        false,
                        'lax'
                    )
                );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }

    public function signOut()
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return $this->successResponse(null, 'Successfully logout');
    }

    public function signUp(array $data)
    {
        try {
            if ($data['password'] !== $data['cpassword']) {
                throw new \Exception('Password do not match', 422);
            }

            $slug = Str::of($data['company'])->slug('-');

            $tenant = Tenant::query()->tenant($slug)->exists();

            if (! $tenant) {
                throw new \Exception('Company does not exist', 422);
            }

            DB::transaction(function () use ($data, $slug) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                $tenant = Tenant::query()->where('name', $data['company'])->first();
                $isOwner = false;

                if (! $tenant) {
                    $tenant = Tenant::create([
                        'name' => $data['company'],
                        'slug' => $slug,
                        'plan' => 'pro',
                    ]);
                    $isOwner = true;
                }

                Member::create([
                    'user_id' => $user->id,
                    'tenant_id' => $tenant->id,
                    'role' => $isOwner ? Roles::OWNER : Roles::MEMBER,
                ]);

                $user->assignRole(
                    $isOwner ? Roles::OWNER : Roles::MEMBER
                );

            });

            return $this->successResponse(null, 'Successfully Register');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }

    }
}
