<?php

namespace Database\Factories;

use App\Models\Mint;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class MintFactory extends Factory
{
    protected $model = Mint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $wallet = Wallet::inRandomOrder()->first();

        return [
            'user_id' => $wallet->user_id,
            'type' => $this->faker->randomElement(['nft', 'ada', 'nft', 'phuffy', 'nft']),
            'group' => $this->faker->words(random_int(2, 3), true),
            'memo' => $this->faker->sentences(random_int(2, 3), true),
            'status' => $this->faker->randomElement(['draft', 'pending', 'minting', 'minted', 'burnt']),
        ];
    }
}
