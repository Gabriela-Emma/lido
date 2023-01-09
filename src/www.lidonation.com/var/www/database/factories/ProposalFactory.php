<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Fund;
use App\Models\Link;
use App\Models\Proposal;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Bluemmb\Faker\PicsumPhotosProvider;
use Database\Factories\Traits\UnsplashProvider;
use DavidBadura\FakerMarkdownGenerator\FakerProvider as FakerMarkdownProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProposalFactory extends Factory
{
    use UnsplashProvider;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $this->faker->addProvider(new FakerMarkdownProvider($this->faker));
        $this->faker->addProvider(new PicsumPhotosProvider($this->faker));

        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'team_id' => fn () => Team::inRandomOrder()?->first()?->id ?? 0,
            'fund_id' => fn () => Fund::inRandomOrder()->first()->id,
            'title' => $this->faker->words(4, true),
            'slug' => fn (array $attributes) => Str::slug($attributes['title']),
            'meta_title' => $this->faker->words(5, true),
            'website' => $this->faker->url(),
            'status' => $this->faker->randomElement([
                'pending' => 'Pending',
                'unfunded' => 'Unfunded',
                'funded' => 'Funded',
                'complete' => 'Complete',
                'retired' => 'Retired',
                'startup' => 'Startup',
                'growth' => 'Growth',
                'expansion' => 'Expansion',
                'matured' => 'Matured',
            ]),
            'social_excerpt' => $this->faker->sentences(rand(2, 3), true),
            'comment_prompt' => $this->faker->sentences(rand(2, 3), true),
            'problem' => $this->faker->sentences(rand(2, 5), true),
            'solution' => $this->faker->sentences(rand(2, 5), true),
            'experience' => $this->faker->sentences(rand(2, 5), true),
            'excerpt' => $this->faker->sentences(rand(2, 5), true),
            'content' => $this->faker->markdown().$this->faker->markdown().$this->faker->markdown(),
            'definition_of_success' => $this->faker->sentences(rand(2, 3), true),
            'amount_requested' => $this->faker->randomFloat(2, 500),
            'funded_at' => $this->faker->randomElement([
                null, null, null,
                $this->faker->dateTimeBetween('-2 Years'),
                null, null, null,
            ]),
            'yes_votes_count' => $this->faker->randomElement([
                null, null, null,
                $this->faker->randomNumber(7),
                $this->faker->randomNumber(5),
            ]),
            'no_votes_count' => $this->faker->randomElement([
                null, null, null,
                $this->faker->randomNumber(7),
                $this->faker->randomNumber(5),
            ]),

        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Proposal $proposal) {
            // add media
            $proposal->addMediaFromBase64($this->getImageUrl())
                ->toMediaCollection('hero');

            $proposal->categories()->attach(
                Category::inRandomOrder()
                    ->limit(random_int(1, 2))
                    ->pluck('id')
                    ->mapToGroups(fn ($tax) => [
                        $tax => ['model_type' => $this->model], ])
                    ->map(fn ($set) => $set->collapse())
            );

            $proposal->links()->attach(
                Link::inRandomOrder()
                    ->limit(random_int(1, 2))
                    ->pluck('id')
                    ->mapToGroups(fn ($tax) => [
                        $tax => ['model_type' => $this->model], ])
                    ->map(fn ($set) => $set->collapse())
            );

            $proposal->tags()
                ->attach(
                    Tag::inRandomOrder()
                        ->limit(random_int(3, 6))
                        ->pluck('id')
                        ->mapToGroups(fn ($tax) => [
                            $tax => ['model_type' => $this->model], ])
                        ->map(fn ($set) => $set->collapse())
                );
        });
    }
}
