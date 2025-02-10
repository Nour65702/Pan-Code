<?php

namespace App\Http\Controllers\Api\Team;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\AcceptInvitationRequest;
use App\Http\Requests\Invitation\InviteRequest;
use App\Models\Team;
use App\Services\Team\InvitationService;


class InvitationController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }


    public function invite(InviteRequest $request, Team $team)
    {
        $validated = $request->validated();

        $data = [
            'email' => $validated['email'],
            'team_id' => $team->id
        ];

        $invitation = $this->invitationService->inviteUser($data);

        $this->invitationService->sendInvitationNotification($invitation);

        return ApiResponse::success(['message' => 'Invitation sent']);
    }


    public function acceptInvitation(AcceptInvitationRequest $request)
    {
        try {
            $this->invitationService->acceptInvitation($request->token);

            return ApiResponse::success(['message' => 'You have successfully joined the team.']);
        } catch (\Exception $e) {
            return ApiResponse::error(['error' => $e->getMessage()], 400);
        }
    }
}
