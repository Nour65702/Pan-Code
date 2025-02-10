<?php


namespace App\Services\Team;

use App\Repositories\Team\TeamRepository;
use Illuminate\Support\Facades\Auth;

class TeamService
{
    protected $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }


    public function createTeam(array $data)
    {
        $data['owner_id'] = Auth::id();
        return $this->teamRepository->create($data);
    }


    public function updateTeam($team, array $data)
    {
        return $this->teamRepository->update($team, $data);
    }


    public function deleteTeam($team)
    {
        return $this->teamRepository->delete($team);
    }
}
