<?php

namespace Database\Factories;

use App\Models\Repo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repo>
 */
class RepoFactory extends Factory
{
    protected $model = Repo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fn () => User::inRandomOrder()->first()->id,
            'name' => $this->faker->words(rand(2, 4), true),
            'model_id' => '1',
            'model_type' => 'editMe',
            'url' => 'https://github.com/'.$this->faker->word(rand(3, 8), true),
            'tracked_branch' => 'branch',

        ];
    }
}
