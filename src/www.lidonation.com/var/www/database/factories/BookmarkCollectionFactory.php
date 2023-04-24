<?php

namespace Database\Factories;

use App\Models\BookmarkCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookmarkCollection>
 */
class BookmarkCollectionFactory extends Factory
{
    protected $model = BookmarkCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(4, true),
            'color' => $this->faker->safeHexColor(),
            'visibility' => true,
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),

        ];
    }
}
