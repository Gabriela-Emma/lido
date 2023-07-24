<?php

use App\Models\User;
use App\Models\Reward;
use App\Models\LearningLesson;
use App\Models\LearningAttempt;
use App\Repositories\AdaRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    protected AdaRepository $adaRepository;

    public function __construct()
    {
        $this->adaRepository = app(AdaRepository::class);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        LearningAttempt::where('status', 'completed')->whereDoesntHave('learning.rewards')->each(
            function ($attempt) {
                $learningLesson = LearningLesson::findOrFail($attempt->learning_lesson_id);
                $user = User::findOrFail($attempt->user_id);
                // get first rule
                $reward = new Reward;
                $reward->user_id = $attempt->user_id;
                $reward->model_id = $attempt->learning_lesson_id;
                $reward->model_type = LearningLesson::class;

                // get related giveaway
                $giveaway = $learningLesson->topic->giveaway;
                $rule = $giveaway->rules->first();
                if (($rule?->subject ?? null) !== 'usd.amount') {
                    $reward->asset = explode('.',  $rule->subject)[0];
                    $reward->asset_type = 'ft';
                    $reward->amount = $rule->predicate;
                } else {
                    $reward->asset = 'lovelace';
                    $reward->asset_type = 'ada';
                    $reward->amount = $this->usdInAda();
                }
                $reward->status = 'issued';
                $reward->stake_address = $user->wallet_stake_address;
                $reward->setTranslation('memo', 'en', $learningLesson->title);
                $reward->save();
            }
        );
    }


    protected function usdInAda()
    {
        //fetch quote
        $rewardAmount = -1;
        $quote = $this->adaRepository->quote()?->price ?? null;
        if ($quote) {
            $rewardAmount = 1 / $quote;
        }
        return $rewardAmount > 0 ? number_format($rewardAmount, 6) * 1000000 : 1000000;
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
