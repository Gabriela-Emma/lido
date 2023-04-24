<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $text = $this->faker->sentence(random_int(2, 5), true);

        return [
            'commentator_type' => get_class($user),
            'commentator_id' => $user->id,
            'original_text' => $text,
            'text' => "<p>{$text}</p>",
        ];
    }
}
