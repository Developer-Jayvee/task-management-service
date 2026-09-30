<?php

namespace App\Services\Auth;

use App\Models\InvitationLink;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class InvitationLinkService
{
    use ResponseTrait;

    public function verifyLink(string $link)
    {
        try {
            $payload = Crypt::decrypt($link);

            if (! $payload) {
                throw new \Exception('Link is expired', 422);
            }

            $invitation = InvitationLink::query()->where('code', $payload['code'])->firstOrFail();

            if ($invitation->isExpired()) {
                $invitation->delete();
                throw new \Exception('Link is already expired', 422);
            }

            return $this->successResponse([
                'slug' => $payload['slug'],
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
    public static function removeUsedLinks(string $link)
    {
        $payload = Crypt::decrypt($link);

        if (! $payload) return false;
        $invitation = InvitationLink::query()->where('code', $payload['code'])->first();
        if($invitation) return $invitation->delete();
        return false;
    }

    public function generateLink()
    {
        try {
            $tenant = request()->user()->getTenant();

            if (! $tenant) {
                throw new \Exception('User is not authorized to generate link');
            }
            $code = Str::random(8);

            $payload = [
                'code' => $code,
                'slug' => $tenant?->name,
            ];

            $link = Crypt::encrypt($payload);
            $formatted = env('APP_CLIENT_URL') . "/register?link=$link";
            InvitationLink::create([
                'code' => $code,
                'user_id' => request()->user()->id,
                'tenant_id' => $tenant->id,
                'link' => $link,
            ]);

            return $this->successResponse($formatted, 'Successfully generated link');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
