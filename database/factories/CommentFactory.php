<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Article;
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
    public function definition()
    {
        return [
            'value' => $this->faker->numberBetween($min = 1, $max = 5),
            'description' => $this->faker->realText(255),
            'user_id' => User::all()->random()->id,
            'article_id' => Article::all()->random()->id,

        ];
    }
}
