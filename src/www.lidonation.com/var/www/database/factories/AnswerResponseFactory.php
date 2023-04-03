<?php

namespace Database\Factories;

use App\Models\AnswerResponse;
use App\Models\Quiz;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class AnswerResponseFactory extends Factory
{
    protected $model = AnswerResponse::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $quiz = Quiz::inRandomOrder()->first();
        $question = $quiz->questions()->first();
        $question_answers = DB::table('question_answers')->where('question_id', $question->id)->get();

        return [
            "quiz_id" => $quiz->id,
            'question_id' => $question->id,
            'question_answer_id' => $question_answers->first()->id,
            'status' => $this->faker->randomElement(['published', 'draft', 'published', 'pending', 'published']),
        ];
    }
}
