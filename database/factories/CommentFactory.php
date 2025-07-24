<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::all()->pluck("id")->toArray();
        $postId = Post::all()->pluck("id")->toArray();

        return [
            "user_id"   => $this->faker->randomElement($userId),
            "post_id"   => $this->faker->randomElement($postId),
            "content"   => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed sollicitudin sapien. Fusce vestibulum enim sit amet porta iaculis.",
        ];
    }
}
