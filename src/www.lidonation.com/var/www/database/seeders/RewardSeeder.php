<?php

namespace Database\Seeders;

use App\Models\Reward;
use App\Models\Translation;
use App\Models\Tx;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Reward::factory(5)
            ->has(
                Translation::factory()
                    ->state(function (array $attributes, Reward $reward) {
                        return [
                            'source_id' => $reward->id,
                            'source_type' => $reward::class,
                            'source_field' => 'memo',
                            'source_content' => $reward->memo,
                            'source_lang' => 'en',
                        ];
                    }),
                'translations'
            )->has(
                Tx::factory(3)
                    ->state(function (array $attributes, Reward $reward) {
                        return [
                            'model_id' => $reward->id,
                            'model_type' => $reward::class,
                        ];
                    }),
                'txs'
            )
            ->create();
    }
}
