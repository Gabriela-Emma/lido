<?php

namespace Database\Factories;

use App\Models\MintTx;
use Illuminate\Database\Eloquent\Factories\Factory;

class MintTxFactory extends Factory
{
    protected $model = MintTx::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'score' => $this->generateRandomFloat(0, 100),
            'distribution_percent' => 14.6,
            'amount' => random_int(99, 999),
        ];
    }

    public function generateRandomFloat(float $minValue, float $maxValue): float
    {
        return $minValue + mt_rand() / mt_getrandmax() * ($maxValue - $minValue);
    }
}
