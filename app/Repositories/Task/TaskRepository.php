<?php

namespace App\Repositories\Task;

use App\Models\Task;

class TaskRepository
{

    public function getTasksForTeam($team)
    {
        return $team->tasks();
    }


    public function create(array $data)
    {
        return Task::create($data);
    }


    public function update(Task $task, array $data)
    {
        return $task->update($data);
    }


    public function delete(Task $task)
    {
        return $task->delete();
    }


    public function findById(int $taskId)
    {
        return Task::find($taskId);
    }
}
