<?php

namespace Database\Factories;

use App\Models\Commit;
use App\Models\Repo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commit>
 */
class CommitFactory extends Factory
{
    protected $model = Commit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'repo_id' => Repo::inRandomOrder()->first()->id,
            'content' => $this->faker->sentences(rand(2, 3), true),
            'hash' => 'ksshsjskskks'.$this->faker->word(),
            'author' => User::inRandomOrder()->first()->id,
        ];
    }
}
