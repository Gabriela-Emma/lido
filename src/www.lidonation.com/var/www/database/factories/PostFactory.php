<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Link;
use App\Models\Post;
use App\Models\Reactions\Reaction;
use App\Models\Tag;
use App\Models\User;
use Bluemmb\Faker\PicsumPhotosProvider;
use Database\Factories\Traits\UnsplashProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    use UnsplashProvider;

    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // attach shortcode to content.
        $content = $this->faker->paragraphs(rand(5, 18), true);
        $link = Link::inRandomOrder()->first();
        if ($link) {
            $linkShortcode = '[link model_type="link" id='.$link->id.']'.$link->label.'[/link]';

            $content = substr_replace($content, $linkShortcode, 100, 0);
        }
        $this->faker->addProvider(new PicsumPhotosProvider($this->faker));

        return [
            'parent_id' => $this->faker->randomDigit(),
            'user_id' => fn () => User::inRandomOrder()->first()?->id,
            'title' => $this->faker->words(4, true),
            'meta_title' => $this->faker->words(5, true),
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
            'slug' => fn (array $attributes) => Str::slug($attributes['title']),
            'prologue' => $this->faker->paragraphs(rand(2, 3), true),
            'excerpt' => $this->faker->sentences(rand(2, 5), true),
            'social_excerpt' => $this->faker->sentences(rand(2, 3), true),
            'comment_prompt' => $this->faker->sentences(rand(2, 3), true),
            'content' => ['en' => $content, 'sw' => ''],
            'epilogue' => $this->faker->paragraphs(rand(2, 3), true),
            'created_at' => $this->faker->dateTimeBetween('-2 Years'),
            'published_at' => $this->faker->dateTimeBetween('-2 Years'),
        ];
    }

    /**
     * Indicate that the user is suspended.
     */
    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => $this->faker->dateTimeBetween('-2 Months'),
                'status' => 'published',
            ];
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            $this->afterCreatingJobs($post);
        });
    }

    protected function afterCreatingJobs(Post $post): void
    {
        // add media
        if (! app()->environment('testing')) {
            $post->addMediaFromBase64($this->getImageUrl())
                ->toMediaCollection('hero');
        }

        Reaction::factory()
            ->count(random_int(2, 3))
            ->create([
                'model_type' => $this->model,
                'model_id' => $post->id,
            ]);

        $post->links()->attach(
            Link::inRandomOrder()
                ->limit(random_int(1, 2))
                ->pluck('id')
                ->mapToGroups(fn ($tax) => [
                    $tax => ['model_type' => $this->model], ])
                ->map(fn ($set) => $set->collapse())
        );

        $post->categories()->attach(
            Category::inRandomOrder()
                ->limit(random_int(1, 2))
                ->pluck('id')
                ->mapToGroups(fn ($tax) => [
                    $tax => ['model_type' => $this->model], ])
                ->map(fn ($set) => $set->collapse())
        );

        $post->tags()
            ->attach(
                Tag::inRandomOrder()
                    ->limit(random_int(3, 6))
                    ->pluck('id')
                    ->mapToGroups(fn ($tax) => [
                        $tax => ['model_type' => $this->model], ])
                    ->map(fn ($set) => $set->collapse())
            );
    }
}
