<?php

namespace Database\Factories;

use App\Models\CatalystExplorer\CatalystReport;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatalystExplorer\CatalystReport>
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
