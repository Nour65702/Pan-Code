<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_creation_by_owner()
    {
        $user = User::factory()->create(); // Create a user

        $this->actingAs($user, 'sanctum'); // Authenticate the user

        $response = $this->postJson('/api/v1/teams', [
            'name' => 'Test Team'
        ]);

        $response->assertStatus(201) // Expecting a success response
            ->assertJsonStructure(['id', 'name', 'owner_id']);

        $this->assertDatabaseHas('teams', ['name' => 'Test Team']);
    }
}
