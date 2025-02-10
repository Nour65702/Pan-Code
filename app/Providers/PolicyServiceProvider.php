<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Team;
use App\Models\Task;
use App\Models\User;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // Team Policies
        Gate::define('update-team', function (User $user, Team $team) {
            return $user->id === $team->owner_id;
        });

        Gate::define('delete-team', function (User $user, Team $team) {
            return $user->id === $team->owner_id;
        });

        // Task Policies
        Gate::define('update-task', function (User $user, Task $task) {
            return $user->id === $task->assigned_to || $user->id === $task->team->owner_id;
        });

        Gate::define('delete-task', function (User $user, Task $task) {
            return $user->id === $task->assigned_to || $user->id === $task->team->owner_id;
        });

    }
}
