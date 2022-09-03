<?php

namespace Database\Factories\New;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\New\Showcase>
 */
class ShowcaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userId = User::pluck('id');
        return [
            'title' => $this->faker->title(),
            'slug' => Str::slug($this->faker->title()),
            'description' => fake()->paragraph(2, true),
            'user_id' => fake()->randomElement($userId),
        ];
    }
}
