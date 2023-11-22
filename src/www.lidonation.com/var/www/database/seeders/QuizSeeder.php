<?php

namespace Database\Seeders;

use App\Models\EveryEpoch;
use App\Models\Giveaway;
use App\Models\Post;
use App\Models\Quiz;
use App\Models\Translation;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

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
            ->hasAttached(Post::factory(), ['model_type' => Post::class], 'posts')
            ->hasAttached(Giveaway::factory()->count(1), ['model_type' => Quiz::class], 'giveaways')
            ->has(
                Translation::factory()
                    ->state(function (array $attributes, Quiz $quiz) {
                        return [
                            'source_id' => $quiz->id,
                            'source_type' => $quiz::class,
                            'source_field' => 'content',
                            'source_content' => $quiz->content,
                            'source_lang' => 'en',
                        ];
                    }),
                'translations'
            )
            ->create();

        Quiz::factory(5)
            ->hasAttached(EveryEpoch::factory()->count(2), ['model_type' => EveryEpoch::class], 'everyEpochs')
            ->hasAttached(Post::factory(), ['model_type' => Post::class], 'posts')
            ->hasAttached(Giveaway::factory()->count(1), ['model_type' => Quiz::class], 'giveaways')
            ->create();
    }
}
