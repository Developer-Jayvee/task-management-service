<?php

namespace App\Services\Auth;

use App\Models\InvitationLink;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class InvitationLinkService
{
    use ResponseTrait;

    public function verifyLink(string $link)
    {
        try {
            $payload = Crypt::decrypt($link);
    
            if(! $payload) {
                throw new \Exception("Link is invalid or expired",422);
            }
    
            $invitation = InvitationLink::query()->where('code',$payload['code'])->firstOrFail();

            if($invitation->isExpired()) {
                throw new \Exception("Link is already expired", 422);
            }

            
            $invitation->delete();
    
            return $this->successResponse([
                'slug' => $payload['slug']
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }

    }
    public function generateLink()
    {
        try {
            $tenant = request()->user()->tenant;
    
            if(! $tenant) {
                throw new \Exception("User is not authorized to generate link");
            }
            $code = Str::random(8);
            
            $payload = [
                'code' => $code,
                'slug' => $tenant?->slug,
            ];
    
            $link = Crypt::encrypt($payload);
            
            InvitationLink::create([
                'code' => $code,
                'user_id' => request()->user()->id,
                'tenant_id' => $tenant->id,
                'link' => $link,
            ]);
    
            return $this->successResponse([ 'link' => $link ],'Successfully generated link');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception);
        }
    }
}
