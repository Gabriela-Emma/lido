<?php

namespace Database\Seeders;

use App\Models\LearningLesson;
use App\Models\LearningModule;
use App\Models\LearningTopic;
use App\Models\Translation;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class LearningModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker): void
    {
        LearningModule::factory(3)
            ->has(
                Translation::factory()
                    ->state(function (array $attributes, LearningModule $lm) use ($faker) {
                        return [
                            "source_id" => $lm->id,
                            "source_type" => $lm::class,
                            "source_field" => 'title',
                            "source_content" => $lm->title,
                            "source_lang" => 'en',
                        ];
                    }),
                'translations'
            )
            ->hasAttached(
                LearningTopic::factory(rand(4, 15))
                    ->hasAttached(
                        LearningLesson::factory(rand(5, 12))
                    )
            )->create();
    }
}
