<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_get_all_tasks(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Task::factory()->count(10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson(route('tasks.index'));
        $response->assertStatus(200);

        $this->assertDatabaseCount('tasks', 10);
    }

    public function test_if_tasks_can_be_retrieved_without_authenticated(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson(route('tasks.index'));
        $response->assertStatus(401);

        $this->assertDatabaseCount('tasks', 10);
    }

    public function test_if_task_can_be_created(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $payload = [
            'name' => fake()->name,
            'description' => fake()->sentence(),
            'start_date' => "22-10-2024",
            'due_date' => "22-11-2024"
        ];

        $response = $this->postJson(route('tasks.store'), $payload);
        $response->assertStatus(201);

        $this->assertDatabaseCount('tasks', 1);

    }

    public function test_if_task_cannot_be_created_if_validation_is_not_met(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $payload = [
            'name' => "",
            'description' => fake()->sentence(),
            'start_date' => "22-10-2024",
            'due_date' => "22-11-2024"
        ];

        $response = $this->postJson(route('tasks.store'), $payload);
        $response->assertStatus(422);
        $this->assertDatabaseCount('tasks', 0);

    }

    public function test_if_task_can_be_updated(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $task = Task::factory()->create(['user_id' => $user->id]);
        $payload = [
            'name' => fake()->name,
            'description' => fake()->sentence(),
            'start_date' => "22-10-2024",
            'due_date' => "22-11-2024"
        ];

        $response = $this->putJson(route('tasks.update', $task), $payload);
        $response->assertStatus(200);

        $this->assertDatabaseCount('tasks', 1);

    }


    public function test_if_task_can_be_deleted(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $task = Task::factory()->create(['user_id' => $user->id]);
    
        $response = $this->deleteJson(route('tasks.update', $task));
        $response->assertStatus(200);

        $this->assertDatabaseCount('tasks', 0);

    }


}
