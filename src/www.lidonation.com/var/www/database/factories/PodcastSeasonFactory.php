<?php

namespace Database\Factories;

use App\Models\PodcastSeason;
use App\Models\PodcastShow;
use App\Models\User;
use DavidBadura\FakerMarkdownGenerator\FakerProvider as FakerMarkdownProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PodcastSeason>
 */
class PodcastSeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new FakerMarkdownProvider($this->faker));

        return [
            'user_id' => User::factory(),
            'host_id' => User::factory(),
            'show_id' => PodcastShow::factory(),
            'name' => $this->faker->words(4, true),
            'content' => $this->faker->markdown().$this->faker->markdown(),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
        ];
    }
}
