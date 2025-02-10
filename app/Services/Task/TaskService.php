<?php

namespace App\Services\Task;

use App\Models\Team;
use App\Models\Task;
use App\Repositories\Task\TaskRepository;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }


    public function getTasks(Team $team, array $filters)
    {
        $query = $this->taskRepository->getTasksForTeam($team);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }

        return $query->paginate(10);
    }



    public function createTask(Team $team, array $data)
    {

        $this->validateTeamMember($team, $data['assigned_to']);

        $data['team_id'] = $team->id;
        return $this->taskRepository->create($data);
    }


    public function updateTask(Task $task, array $data)
    {
        if (isset($data['assigned_to'])) {
            $this->validateTeamMember($task->team, $data['assigned_to']);
        }

        $this->taskRepository->update($task, $data);
        return $task;
    }


    public function deleteTask(Task $task)
    {
        return $this->taskRepository->delete($task);
    }


    protected function validateTeamMember(Team $team, int $userId)
    {
        if (!$team->members()->where('user_id', $userId)->exists()) {
            throw new \Exception('Assigned user must be a team member.');
        }
    }


    public function findTaskById(int $taskId)
    {
        return $this->taskRepository->findById($taskId);
    }
}
