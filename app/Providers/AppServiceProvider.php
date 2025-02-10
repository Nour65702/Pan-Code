<?php

namespace App\Providers;

use App\Repositories\Task\TaskRepository;
use App\Repositories\Team\TeamInvitationRepository;
use App\Repositories\Team\TeamRepository;
use App\Services\Task\TaskService;
use App\Services\Team\InvitationService;
use App\Services\Team\TeamService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TeamRepository::class, TeamRepository::class);
        $this->app->bind(TeamService::class, TeamService::class);
        $this->app->bind(TeamInvitationRepository::class, TeamInvitationRepository::class);
        $this->app->bind(InvitationService::class, InvitationService::class);
        $this->app->bind(TaskRepository::class, TaskRepository::class);
        $this->app->bind(TaskService::class, TaskService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
