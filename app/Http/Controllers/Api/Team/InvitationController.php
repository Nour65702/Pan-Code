<?php

namespace App\Http\Controllers\Api\Team;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\AcceptInvitationRequest;
use App\Http\Requests\Invitation\InviteRequest;
use App\Models\Team;
use App\Services\Team\InvitationService;
use App\Services\TryCatchService;
use Illuminate\Support\Facades\DB;

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

        return TryCatchService::execute(
            function () use ($validated, $team) {
                return DB::transaction(function () use ($validated, $team) {
                    $data = [
                        'email' => $validated['email'],
                        'team_id' => $team->id
                    ];

                    $invitation = $this->invitationService->inviteUser($data);
                    $this->invitationService->sendInvitationNotification($invitation);

                    return ApiResponse::success(['message' => 'Invitation sent']);
                });
            },
            function () {
                DB::rollBack();
            }
        );
    }


    public function acceptInvitation(AcceptInvitationRequest $request)
    {
        return TryCatchService::execute(
            function () use ($request) {
                $this->invitationService->acceptInvitation($request->token);
                return ApiResponse::success(['message' => 'You have successfully joined the team.']);
            },
            function () {}
        );
    }
}
