<?php

namespace App\Services\Team;

use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TeamInvitationNotification;
use App\Repositories\Team\TeamInvitationRepository;

class InvitationService
{
    protected $teamInvitationRepository;

    public function __construct(TeamInvitationRepository $teamInvitationRepository)
    {
        $this->teamInvitationRepository = $teamInvitationRepository;
    }


    public function inviteUser(array $data)
    {
        return $this->teamInvitationRepository->create($data);
    }


    public function acceptInvitation(string $token)
    {
        $invitation = $this->teamInvitationRepository->findByToken($token);

        if (!$invitation) {
            throw new \Exception('Invalid invitation token');
        }

        $user = User::where('email', $invitation->email)->first();

        if (!$user) {
            throw new \Exception('User not found. Register first.');
        }


        $teamUser = TeamUser::create([
            'team_id' => $invitation->team_id,
            'user_id' => $user->id
        ]);


        $this->teamInvitationRepository->delete($invitation);

        return $teamUser;
    }


    public function sendInvitationNotification($invitation)
    {
        Notification::route('mail', $invitation->email)
            ->notify(new TeamInvitationNotification($invitation));
    }
}
