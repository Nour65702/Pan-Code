<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function update(User $user, Task $task)
    {
        return $user->id === $task->assigned_to || $user->id === $task->team->owner_id;
    }

    /**
     * Determine if the user can delete the task.
     */
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->assigned_to || $user->id === $task->team->owner_id;
    }
}
