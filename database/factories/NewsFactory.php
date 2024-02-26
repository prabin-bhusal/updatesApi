<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['published', 'unpublished', 'draft']);
        $title = $this->faker->sentence(2);
        $slug = Str::slug($title, '-');
        return [
            'title' => rtrim($title, '.'),
            'slug' => $slug,
            'content' => fake()->paragraph(5),
            'banner_image' => 'default.jpg',
            'user_id' => User::factory(),
            'status' => $status,
        ];
    }
}
