<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\User;
use App\Models\Promo;
use Database\Factories\Traits\UnsplashProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    use UnsplashProvider;
    protected $model = Promo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $nft = Nft::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'title' => $this->faker->words(4, true),
            'uri'=> $this->faker->url(),
            'token_type' => Nft::class,
            'token_id' => $nft?->id,
            'status' => $this->faker->randomElement(['draft', 'scheduled', 'retired', 'published']),
            'type' => 'partner',
            'content' => ['en' => $this->faker->sentences(rand(2, 5), true), 'sw' => ''],
        ];
    }
}
