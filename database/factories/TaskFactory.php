<?php

namespace Database\Factories;

use App\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            "description" => fake()->sentence(),
            "start_date" => fake()->date('d-m-Y'),
            "due_date" => fake()->date('d-m-Y'),
            "status" => fake()->randomElement(TaskStatusEnum::cases()) 
        ];
    }
}
