<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::all()->pluck("id")->toArray();

        return [
            "user_id"   => $this->faker->randomElement($userId),
            "slug"      => $this->faker->unique()->slug(),
            "title"     => $this->faker->jobTitle(),
            "content"   => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed sollicitudin sapien. Fusce vestibulum enim sit amet porta iaculis. Vestibulum mattis dui quis elit tincidunt commodo. Vivamus tristique pharetra lobortis.",
        ];
    }
}
