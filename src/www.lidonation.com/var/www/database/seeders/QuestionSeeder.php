<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionAnswer;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::factory(10)->create()->each(function ($quiz) {
            $correctAnswer = rand(1, 4); 
            $quiz->answers()->saveMany(QuestionAnswer::factory(4)
                ->make()
                ->map(function ($answer, $index) use ($correctAnswer) {
                    $answer['correctness'] = $index === $correctAnswer - 1 ? 'true' : 'false';
                   
                    return $answer;
                })
                ->all()
            );
        });
    }
}
