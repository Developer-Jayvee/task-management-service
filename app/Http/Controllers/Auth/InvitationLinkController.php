<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\InvitationLinkService;
use Illuminate\Http\Request;

class InvitationLinkController extends Controller
{
    public function __construct(
        protected InvitationLinkService $_invitationService
    ) {}

    public function verify(Request $request)
    {
        $this->authorize('resetPassword',User::class);
        
        return $this->_invitationService->verifyLink(
            link : $request->query('link')
        );
    }

    public function generate(Request $request)
    {
        $this->authorize('resetPassword',User::class);

        return $this->_invitationService->generateLink();
    }
}
