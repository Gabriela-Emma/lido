<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\TwitterEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TwitterEvent>
 */
class TwitterEventFactory extends Factory
{
    protected $model = TwitterEvent::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'event_id' => Event::inRandomOrder()->first()->id,
            'type' => 'space',
        ];
    }
}
