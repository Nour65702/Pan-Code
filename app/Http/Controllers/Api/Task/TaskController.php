<?php

namespace App\Http\Controllers\Api\Task;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Models\Team;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $tasks = $this->taskService->getTasks($team, $request->all());

        return ApiResponse::success(TaskResource::collection($tasks));
    }


    public function store(TaskRequest $request, Team $team)
    {
        if (!$team->members()->where('user_id', Auth::id())->exists()) {
            return ApiResponse::error(['message' => 'Only team members can create tasks.']);
        }

        $validatedData = $request->validated();
        $task = $this->taskService->createTask($team, $validatedData);

        return ApiResponse::success(TaskResource::make($task));
    }


    public function show(Task $task)
    {
        if (!$task->team->members()->where('user_id', Auth::id())->exists()) {
            return ApiResponse::error(['message' => 'You are not authorized to view this task.']);
        }

        return ApiResponse::success(TaskResource::make($task));
    }


    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $validatedData = $request->validated();
        $task = $this->taskService->updateTask($task, $validatedData);

        return ApiResponse::success(TaskResource::make($task));
    }


    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);

        return ApiResponse::success(['message' => 'Task deleted']);
    }
}
