<?php

namespace App\Repositories\Team;

use App\Models\TeamInvitation;
use Illuminate\Support\Facades\Hash;

class TeamInvitationRepository
{

    public function create(array $data)
    {
        return TeamInvitation::create([
            'email' => $data['email'],
            'team_id' => $data['team_id'],
            'token' => Hash::make($data['email'] . now())
        ]);
    }


    public function findByToken(string $token)
    {
        return TeamInvitation::where('token', $token)->first();
    }

  
    public function delete(TeamInvitation $invitation)
    {
        return $invitation->delete();
    }
}
