<?php

namespace Database\Factories;

use App\Models\CatalystExplorer\Fund;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FundFactory extends Factory
{
    protected $model = Fund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => fn () => User::inRandomOrder()->first()?->id,
            'title' => $this->faker->words(4, true),
            'meta_title' => $this->faker->words(5, true),
            'status' => $this->faker->randomElement(['launched', 'retired']),
            'excerpt' => $this->faker->sentences(rand(2, 5), true),
            'comment_prompt' => $this->faker->sentences(rand(2, 3), true),
            'content' => $this->faker->paragraphs(rand(5, 18), true),
            'launched_at' => $this->faker->dateTimeBetween('-2 Years'),
            'awarded_at' => $this->faker->dateTimeBetween('-1 Years'),
            'amount' => $this->faker->randomFloat(2, 5000),
            'parent_id' => $this->faker->randomElement([
                Fund::inRandomOrder()->first()?->id, null,
                null, null, null, null, null, null, null,
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
        return $this->afterCreating(function (Fund $fund) {
            // add media
            $url = $this->faker->imageUrl(2400, 1600);
            $fund->addMediaFromUrl($url)
                ->toMediaCollection('hero');

            $fund->categories()->attach(
                Category::inRandomOrder()
                    ->limit(random_int(1, 2))
                    ->pluck('id')
                    ->mapToGroups(fn ($tax) => [
                        $tax => ['model_type' => $this->model], ])
                    ->map(fn ($set) => $set->collapse())
            );

            $fund->tags()
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
