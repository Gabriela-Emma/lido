<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Meta;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(random_int(3, 7), true),
            'content' => $this->faker->paragraphs(random_int(2, 8), true),
            'status' => $this->faker->randomElement(['draft', 'published', 'pending']),
            'parent_id' => $this->faker->randomElement([
                Assessment::inRandomOrder()->first()?->id,
                null, null, null, null, null, null,
            ]),
            'model_id' => Post::inRandomOrder()->first()->id,
            'model_type' => Post::class,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Assessment $comment) {
            Meta::factory([
                'model_type' => Assessment::class,
                'model_id' => $comment->id,
                'key' => 'name',
                'content' => $this->faker->name(),
            ])->create();
            Meta::factory([
                'model_type' => Assessment::class,
                'model_id' => $comment->id,
                'key' => 'email',
                'content' => $this->faker->unique()->safeEmail(),
            ])->create();
        });
    }
}
