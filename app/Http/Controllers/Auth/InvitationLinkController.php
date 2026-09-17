<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationRequest;
use App\Services\Auth\InvitationLinkService;
use Illuminate\Http\Request;

class InvitationLinkController extends Controller
{
    public function __construct(
        protected InvitationLinkService $_invitationService
    ) {}

    public function verify(InvitationRequest $request)
    {
        return $this->_invitationService->verifyLink(
            link : $request->validated('link')
        );
    }

    public function generate(Request $request)
    {
        return $this->_invitationService->generateLink();
    }
}
