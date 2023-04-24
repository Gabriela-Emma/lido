<?php

namespace Database\Factories;

use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdrawal>
 */
class WithdrawalFactory extends Factory
{
    protected $model = Withdrawal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $wallet = Wallet::inRandomOrder()->first();

        return [
            'user_id' => $wallet->user_id,
            'wallet_address' => $wallet->address,
            'status' => $this->faker->randomElement(['processing', 'validated', 'paid', 'sending', 'sent']),
        ];
    }
}
