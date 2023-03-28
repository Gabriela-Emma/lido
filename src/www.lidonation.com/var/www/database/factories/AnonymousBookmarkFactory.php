<?php

namespace Database\Factories;
use App\Models\AnonymousBookmark;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnonymousBookmark>
 */
class AnonymousBookmarkFactory extends Factory
{
    
    protected $model = AnonymousBookmark::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'bookmark' => $this->faker->sentence(),
            'created_at' => now(),
        ];
    }
}
