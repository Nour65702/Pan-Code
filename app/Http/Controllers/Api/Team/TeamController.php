<?php

namespace App\Http\Controllers\Api\Team;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamRequest;
use App\Http\Resources\Team\TeamResource;
use App\Models\Team;
use App\Services\Team\TeamService;
use App\Services\TryCatchService;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }


    public function store(TeamRequest $request)
    {
        return TryCatchService::execute(
            function () use ($request) {
                return DB::transaction(function () use ($request) {
                    $validated = $request->validated();
                    $team = $this->teamService->createTeam($validated);

                    return ApiResponse::success([
                        'message' => 'Team created successfully',
                        'team' => TeamResource::make($team)
                    ]);
                });
            },
            function () {
                DB::rollBack();
            }
        );
    }


    public function update(TeamRequest $request, Team $team)
    {
        $this->authorize('update', $team);

        return TryCatchService::execute(
            function () use ($request, $team) {
                return DB::transaction(function () use ($request, $team) {
                    $validated = $request->validated();
                    $this->teamService->updateTeam($team, $validated);

                    return ApiResponse::success([
                        'message' => 'Team updated successfully',
                        'team' => TeamResource::make($team)
                    ]);
                });
            },
            function () {
                DB::rollBack();
            }
        );
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        return TryCatchService::execute(
            function () use ($team) {
                $this->teamService->deleteTeam($team);
                return ApiResponse::success([
                    'message' => 'Team deleted successfully'
                ]);
            },
            function () {}
        );
    }
}
