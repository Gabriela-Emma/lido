<?php

namespace Database\Factories;

use App\Models\Giveaway;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reward>
 */
class RewardFactory extends Factory
{
    protected $model = Reward::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $giveaway = Giveaway::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'stake_address' => 'stake_test1faociamehsdkfsfjdfjs'.$this->faker->unique()->word(8),
            'model_id' => $giveaway->id,
            'model_type' => $giveaway::class,
            'asset_type' => $this->faker->randomElement(['ft', 'nft', 'ada', 'fiat']),
            'asset' => $this->faker->words(4, true),
            'amount' => $this->faker->numberBetween(100, 10000),
            'memo' => $this->faker->sentences(rand(2, 3), true),
            'status' => $this->faker->randomElement(['draft', 'pending', 'issued']),

        ];
    }
}
