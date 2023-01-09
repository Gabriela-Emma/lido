<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\Podcast;
use App\Models\PodcastSeason;
use App\Models\PodcastShow;
use App\Models\User;
use DavidBadura\FakerMarkdownGenerator\FakerProvider as FakerMarkdownProvider;
use Faker\Provider\Youtube;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Podcast>
 */
class PodcastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new FakerMarkdownProvider($this->faker));
        $this->faker->addProvider(new Youtube($this->faker));

        return [
            'user_id' => User::factory(),
            'nft_id' => Nft::factory(),
            'show_id' => PodcastShow::factory(),
            'season_id' => PodcastSeason::factory(),
            'episode' => rand(1, 68),
            'title' => $this->faker->words(4, true),
            'meta_title' => $this->faker->words(5, true),
            'content' => $this->faker->markdown().$this->faker->markdown(),
            'youtube_id' => explode('v=', $this->faker->youtubeUri())[1],
            'published_link' => $this->faker->url(),
            'social_excerpt' => $this->faker->sentences(rand(2, 3), true),
            'comment_prompt' => $this->faker->sentences(rand(2, 3), true),
            'recorded_at' => $this->faker->randomElement([
                null, null, null,
                $this->faker->dateTimeBetween('-2 Years'),
                null, null, null,
            ]),
            'published_at' => $this->faker->randomElement([
                null, null, null,
                $this->faker->dateTimeBetween('-2 Years'),
                null, null, null,
            ]),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'length' => rand(68, 300),
        ];
    }
}
