<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function update(User $user, Team $team)
    {
        return $user->id === $team->owner_id; // Only owner can update
    }

    public function delete(User $user, Team $team)
    {
        return $user->id === $team->owner_id; // Only owner can delete
    }

    public function manage(User $user, Team $team)
    {
        return $user->id === $team->owner_id; // Manage access for API middleware
    }

}
