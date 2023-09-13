<?php

use App\Models\LearningLesson;
use App\Models\LearningTopic;
use App\Models\Reward;
use App\Models\User;
use App\Repositories\AdaRepository;
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
        $topics = LearningTopic::all();
        $lastLessons = collect([]);

        foreach ($topics as $topic) {
            $lastLesson = $topic->learningLessons()->orderBy('order', 'desc')->first();

            $lastLessons[] = $lastLesson;
        }

        User::whereHas('roles', fn ($query) => $query->whereIn('name', ['learner']))->each(
            function ($user) use ($lastLessons) {
                $lastLessons->each(
                    function ($lesson) use ($user) {
                        $lessonReward = Reward::where([
                            'model_type' => LearningLesson::class,
                            'model_id' => $lesson->id,
                            'user_id' => $user->id,
                        ])->first();
                        if (! $lessonReward instanceof Reward) {
                            $this->issueNft($user, $lesson);
                        }
                    }
                );
            }

        );
    }

    public function issueNft($user, $lesson)
    {
        // get first rule
        $reward = new Reward;
        $reward->user_id = $user->id;
        $reward->model_id = $lesson->id;
        $reward->model_type = LearningLesson::class;

        // get related giveaway
        $giveaway = $lesson?->topic?->giveaway;
        $rule = $giveaway?->rules->first();
        if (($rule?->subject ?? null) !== 'usd.amount') {
            $reward->asset = explode('.', $rule?->subject)[0];
            $reward->asset_type = 'ft';
            $reward->amount = 2000000;
        } else {
            $reward->asset = 'lovelace';
            $reward->asset_type = 'ada';
            $reward->amount = 2000000;
        }
        $reward->status = 'issued';
        $reward->stake_address = $user?->wallet_stake_address;
        $reward->setTranslation('memo', 'en', $lesson->title);
        $reward->save();
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
