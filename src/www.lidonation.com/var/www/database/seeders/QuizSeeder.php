<?php

namespace Database\Seeders;

use App\Models\EveryEpoch;
use App\Models\Giveaway;
use App\Models\Insight;
use App\Models\News;
use App\Models\Quiz;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Quiz::factory(5)
            ->hasAttached(EveryEpoch::factory()->count(2), ['model_type' => EveryEpoch::class], 'everyEpochs')
            ->hasAttached(News::factory(), ['model_type' => News::class], 'posts')
            ->hasAttached(Giveaway::factory()->count(1), ['model_type' => Quiz::class], 'giveaways')
            ->has(
                Translation::factory()
                    ->state(function (array $attributes, Quiz $quiz) use ($faker) {
                        return [ 
                            "source_id" => $quiz->id,
                            "source_type" => $quiz::class,
                            "source_field" => 'content',
                            "source_content" => $quiz->content,
                            "source_lang" => 'en',
                        ];
                    }),
                'translations'
            )
            ->create();

        Quiz::factory(5)
            ->hasAttached(EveryEpoch::factory()->count(2), ['model_type' => EveryEpoch::class], 'everyEpochs')
            ->hasAttached(Insight::factory(), ['model_type' => Insight::class], 'posts')
            ->hasAttached(Giveaway::factory()->count(1), ['model_type' => Quiz::class], 'giveaways')
            ->create();
    }
}