<?php

namespace Database\Factories\Reactions;

use App\Enums\ReactionEnum;
use App\Models\Reactions\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotificationRequest>
 */
class ReactionFactory extends Factory
{
    protected $model = Reaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reaction = $this->faker->randomElement(['❤️', '👍', '🎉', '🚀', '👎', '👀']);
        $commenter = User::inRandomOrder()?->first();

        return [
            'commenter_type' => $commenter::class,
            'commenter_id' => $commenter->id,
            'reaction' => $reaction,
            'type' => ReactionEnum::getClass($reaction),
        ];
    }
}
