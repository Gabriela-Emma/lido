<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class QuestionsAnswersFromSalesforce extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function run()
    {
        $questions = Items::fromFile(database_path().'/files/questions.json');
        foreach ($questions as $sfQuestion) {
            // find the post
            $p = Post::where('slug', $sfQuestion->slug)->first();

            if (! $p instanceof Post) {
                Log::error('Error logging Question', (array) $sfQuestion);

                continue;
            }

            // maybe find related quiz
            $quiz = Quiz::updateOrCreate([
                'title->en' => $p->title,
                'user_id' => 3,
            ], [
                'title->en' => $p->title,
                'status' => 'published',
                'content' => '',
                'user_id' => 3,
            ]);

            $question = Question::where([
                'title->en' => $sfQuestion->en,
                'user_id' => 3,
            ])->whereRelation('metas', 'content', '=', $sfQuestion->sf_id)->first();

            if (! $question instanceof Question) {
                $question = new Question;
                $question->user_id = 3;
                $question->status = 'published';
                $question->type = 'multiple_choice';
                $question->title = [
                    'en' => $sfQuestion->en,
                    'sw' => $sfQuestion->sw,
                ];
                $question->content = "See related article [link post_id={$p->id}]";
                $question->save();

                $question->saveMeta('sf_id', $sfQuestion->sf_id, $question, true);

                $quiz->questions()->syncWithoutDetaching([$question->id]);
            } else {
                $question->title = [
                    'en' => $sfQuestion->en,
                    'sw' => $sfQuestion->sw,
                ];
                $question->content = "See related article [link post_id={$p->id}]";
                $question->save();
            }
        }

        $answers = Items::fromFile(database_path().'/files/answers.json');
        foreach ($answers as $sfAnswer) {
            // find related question
            $question = Question::whereRelation('metas', 'content', '=', $sfAnswer->quiz_sf_id)->first();
            if (! $question instanceof Question) {
                Log::error('Error logging Answer', (array) $sfAnswer);

                continue;
            }

            $answer = QuestionAnswer::updateOrCreate(
                [
                    'content->en' => $sfAnswer->en,
                    'question_id' => $question->id,
                ],
                [
                    'content' => [
                        'en' => $sfAnswer->en,
                        'sw' => $sfAnswer->sw,
                    ],
                    'question_id' => $question->id,
                    'status' => 'published',
                    'correctness' => strtolower($sfAnswer->correctness),
                ]
            );

            $answer->saveMeta('sf_id', $sfAnswer->sf_id, $answer, true);
        }
    }
}
