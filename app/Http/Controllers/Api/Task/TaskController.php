<?php

namespace App\Http\Controllers\Api\Task;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Models\Team;
use App\Services\Task\TaskService;
use App\Services\TryCatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    public function index(Request $request, Team $team)
    {
        if (!$team->members()->where('user_id', Auth::id())->exists()) {
            return ApiResponse::error(['message' => 'Only team members can view tasks.']);
        }

        return TryCatchService::execute(
            function () use ($team, $request) {
                $tasks = $this->taskService->getTasks($team, $request->all());
                return ApiResponse::success(TaskResource::collection($tasks));
            },
            function () {}
        );
    }


    public function store(TaskRequest $request, Team $team)
    {
        if (!$team->members()->where('user_id', Auth::id())->exists()) {
            return ApiResponse::error(['message' => 'Only team members can create tasks.']);
        }

        return TryCatchService::execute(
            function () use ($request, $team) {
                return DB::transaction(function () use ($request, $team) {
                    $validatedData = $request->validated();
                    $task = $this->taskService->createTask($team, $validatedData);
                    return ApiResponse::success(TaskResource::make($task));
                });
            },
            function () {
                DB::rollBack();
            }
        );
    }


    public function show(Task $task)
    {
        if (!$task->team->members()->where('user_id', Auth::id())->exists()) {
            return ApiResponse::error(['message' => 'You are not authorized to view this task.']);
        }

        return TryCatchService::execute(
            function () use ($task) {
                return ApiResponse::success(TaskResource::make($task));
            },
            function () {}
        );
    }


    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        return TryCatchService::execute(
            function () use ($request, $task) {
                return DB::transaction(function () use ($request, $task) {
                    $validatedData = $request->validated();
                    $task = $this->taskService->updateTask($task, $validatedData);
                    return ApiResponse::success(TaskResource::make($task));
                });
            },
            function () {
                DB::rollBack();
            }
        );
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        return TryCatchService::execute(
            function () use ($task) {
                $this->taskService->deleteTask($task);
                return ApiResponse::success(['message' => 'Task deleted']);
            },
            function () {}
        );
    }
}
