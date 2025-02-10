<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_creation_and_assignment()
    {
        $owner = User::factory()->create();
        $team = Team::factory()->create(['owner_id' => $owner->id]);
        $member = User::factory()->create();

        // Add the member to the team
        $team->members()->attach($member->id);

        $this->actingAs($owner, 'sanctum');

        $response = $this->postJson("/api/v1/teams/{$team->id}/tasks", [
            'title' => 'New Task',
            'description' => 'Task assigned to a member',
            'status' => 'pending',
            'due_date' => now()->addDays(5)->toDateString(),
            'assigned_to' => $member->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'description', 'status', 'assigned_to']);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task', 'assigned_to' => $member->id]);
    }

    public function test_task_creation_by_non_team_member_should_fail()
    {
        $owner = User::factory()->create();
        $team = Team::factory()->create(['owner_id' => $owner->id]);
        $non_member = User::factory()->create();

        $this->actingAs($non_member, 'sanctum');

        $response = $this->postJson("/api/v1/teams/{$team->id}/tasks", [
            'title' => 'Unauthorized Task',
            'status' => 'pending',
            'due_date' => now()->addDays(5)->toDateString(),
            'assigned_to' => $owner->id,
        ]);

        $response->assertStatus(400); // Non-team members cannot create tasks
    }
}
