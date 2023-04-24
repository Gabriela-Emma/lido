<?php

namespace Database\Seeders;

use App\Models\Reward;
use App\Models\Tx;
use App\Models\Withdrawal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithdrawalSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Withdrawal::factory(5)
            ->has(
                Reward::factory()->count(3)
                    ->has(
                        Tx::factory(3)
                            ->state(function (array $attributes, Reward $reward) {
                                return [
                                    'model_id' => $reward->id,
                                    'model_type' => $reward::class,
                                ];
                            }),
                        'txs'
                    ),
                'rewards'
            )
            ->has(
                Tx::factory()->state(function (array $attributes, Withdrawal $withdrawal) {
                    return [
                        'model_id' => $withdrawal->id,
                        'model_type' => $withdrawal::class,
                    ];
                    }),
                'txs'
            )
            ->create();
    }
}
