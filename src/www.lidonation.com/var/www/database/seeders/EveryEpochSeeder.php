<?php

namespace Database\Seeders;

use App\Models\EveryEpoch;
use App\Models\Giveaway;
use App\Models\Translation;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class EveryEpochSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        EveryEpoch::factory(10)
            ->hasAttached(Giveaway::factory()->count(1), ['model_type' => EveryEpoch::class], 'giveaways')
            ->has(
                Translation::factory()
                    ->state(function (array $attributes, EveryEpoch $epo) {
                        return [
                            'source_id' => $epo->id,
                            'source_type' => $epo::class,
                            'source_field' => 'content',
                            'source_content' => $epo->content,
                            'source_lang' => 'en',
                        ];
                    }),
                'translations'
            )
            ->create();
    }
}
