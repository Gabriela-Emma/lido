<?php

namespace Database\Seeders;

use App\Models\Giveaway;
use App\Models\Reward;
use App\Models\Rule;
use App\Models\Translation;
use App\Models\Tx;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GiveawaySeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Giveaway::factory(10)
            ->has(
                Translation::factory()
                    ->state(function (array $attributes, Giveaway $giv) use ($faker) {
                        return [ 
                            "source_id" => $giv->id,
                            "source_type" => $giv::class,
                            "source_field" => 'title',
                            "source_content" => $giv->title,
                            "source_lang" => 'en',
                        ];
                    }),
                'translations'
            )->has(
                Rule::factory()
                    ->state(function (array $attributes, Giveaway $giv) {
                        return [
                            "model_id" => $giv->id,
                            "model_type" => $giv::class,
                        ];
                    }),
                'rules'
            )->has(
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
            ->create();
    }
}
