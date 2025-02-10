<?php

namespace App\Repositories\Team;

use App\Models\Team;

class TeamRepository
{

    public function create(array $data)
    {
        return Team::create($data);
    }


    public function update(Team $team, array $data)
    {
        return $team->update($data);
    }


    public function delete(Team $team)
    {
        return $team->delete();
    }

    public function findById(int $id)
    {
        return Team::find($id);
    }
}
