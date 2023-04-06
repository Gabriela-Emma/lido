<?php

namespace Database\Seeders;

use App\Models\OnboardingContent;

class OnboardingContentSeeder extends PostSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OnboardingContent::factory()->published()
            ->hasComments(8)
            ->create([
                'type' => OnboardingContent::class,
                'slug' => 'what-is-cardano-and-how-does-it-use-the-blockchain',
            ]);

        OnboardingContent::factory()->published()
            ->hasComments(2)
            ->create([
                'type' => OnboardingContent::class,
                'slug' => 'what-is-the-point-of-buy-ada-and-staking-in-cardano',
            ]);

        OnboardingContent::factory()->published()
            ->hasComments(3)
            ->create([
                'type' => OnboardingContent::class,
                'slug' => 'how-do-i-buy-ada',
            ]);

        OnboardingContent::factory()->published()
            ->hasComments(5)
            ->create([
                'type' => OnboardingContent::class,
                'slug' => 'how-to-stake-your-ada',
            ]);
    }
}
