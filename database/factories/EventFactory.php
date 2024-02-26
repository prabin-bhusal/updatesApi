<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'content' => fake()->text(255),
            'venue' => fake()->address(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'user_id' => User::factory(),
        ];
    }
}
