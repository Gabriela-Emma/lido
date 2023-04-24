<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Discussion;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ReviewFactory extends PostFactory
{
    protected $model = Review::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Review $review) {
            $this->afterCreatingJobs($review);
            Rating::factory()
                ->count(rand(5, 10))
                ->state(new Sequence(
                    function ($sequence) use ($review) {
                        $discussion = $review->discussions()->inRandomOrder()->first();

                        return [
                            'model_id' => $discussion->id,
                            'model_type' => Discussion::class,
                            'comment_id' => fn () => (Assessment::factory([
                                'model_id' => $discussion->id,
                                'model_type' => Discussion::class,
                            ])->create())->id,
                        ];
                    },
                ))
                ->create();
        });
    }
}
