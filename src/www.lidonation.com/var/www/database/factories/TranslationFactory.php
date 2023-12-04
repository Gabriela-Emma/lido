<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sourceModel = Post::factory()->create();
        $unsplashImage = $this->getUnsplashImageUrl();
        return [
            'content' => $this->faker->text,
            'lang' => $this->faker->randomElement(['sw', 'zh', 'es']),
            'status' => $this->faker->randomElement(['draft', 'pending']),
            'source_type' => 'Post',
            'source_id' => $sourceModel->id,
            'source_field' => $this->faker->word,
            'source_content' => $unsplashImage,
        ];
    }

    /**
     * Get an image URL using UnsplashProvider.
     *
     * @return string
     */
    protected function getUnsplashImageUrl(): string
    {
        $provider = new \Bluemmb\Faker\PicsumPhotosProvider($this->faker);

        return $provider->imageUrl();
    }
}
