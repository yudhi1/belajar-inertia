<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->catchPhrase(),
            'description' => fake()->sentence(12),
            'status' => fake()->randomElement(['active', 'completed', 'on_hold']),
        ];
    }
}
