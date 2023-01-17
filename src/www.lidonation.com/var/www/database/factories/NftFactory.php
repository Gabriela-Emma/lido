<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\Podcast;
use App\Models\User;
use Database\Factories\Traits\UnsplashProvider;
use DavidBadura\FakerMarkdownGenerator\FakerProvider as FakerMarkdownProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Nft>
 */
class NftFactory extends Factory
{
    use UnsplashProvider;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new FakerMarkdownProvider($this->faker));
        $model = collect([Podcast::class])->random();
        $artLink = $this->getRandomImageLink(2048, 2048);

        return [
            'name' => $this->faker->words(rand(2, 3), true),
            'user_id' => User::factory(),
            'artist_id' => User::factory(),
            'model_id' => $this->faker->randomDigit(),
            'model_type' => $model,
            'storage_link' => $artLink,
            'preview_link' => $artLink,
            'policy' => Str::random(20),
            'price' => $this->faker->numberBetween(100, 250),
            'description' => $this->faker->sentence(rand(2, 3)),
            'rarity' => $this->faker->randomElement(['common', 'rare', 'legendary']),
            'status' => $this->faker->randomElement(['draft', 'minting', 'minted']),
            'metadata' => ['motif' => collect(['in the lab', 'portrait', 'bubbles', 'puddles', 'tide pool', 'steampunk museum'])->random()],
        ];
    }
}
