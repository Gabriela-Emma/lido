<?php

namespace Database\Factories;

use App\Models\CatalystReport;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatalystReport>
 */
class CatalystReportFactory extends Factory
{
    protected $model = CatalystReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'proposal_id' => fn () => Proposal::inRandomOrder()->first()->id,
            'content' => $this->faker->sentence(rand(15, 20), true),
        ];
    }
}
