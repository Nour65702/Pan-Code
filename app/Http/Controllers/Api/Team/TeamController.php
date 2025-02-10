<?php

namespace App\Http\Controllers\Api\Team;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamRequest;
use App\Http\Resources\Team\TeamResource;
use App\Models\Team;
use App\Services\Team\TeamService;


class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }


    public function store(TeamRequest $request)
    {
        $validated = $request->validated();

        $team = $this->teamService->createTeam($validated);

        return ApiResponse::success([
            'message' => 'Team created successfully',
            'team' => TeamResource::make($team)
        ]);
    }


    public function update(TeamRequest $request, $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validated();

        $this->teamService->updateTeam($team, $validated);

        return ApiResponse::success([
            'message' => 'Team updated successfully',
            'team' => TeamResource::make($team)
        ]);
    }


    public function destroy($team)
    {
        $this->authorize('delete', $team);

        $this->teamService->deleteTeam($team);

        return ApiResponse::success([
            'message' => 'Team deleted successfully'
        ]);
    }
}
