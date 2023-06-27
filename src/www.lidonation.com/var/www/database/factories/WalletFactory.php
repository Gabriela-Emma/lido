<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'address' => 'addr_test1qze6hr2g2ywal9mskfzh4vym6jq3t9fvcmcyaxeqf8skhct7x'.$this->faker->unique()->word(8),
            'context' => $this->faker->word(),
            'ada_balance' => 0,
            'passphrase' => implode(', ', $this->faker->words(24)),
        ];
    }
}
