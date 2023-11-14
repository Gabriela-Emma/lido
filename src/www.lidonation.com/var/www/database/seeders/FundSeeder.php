<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Fund;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fund::factory()
            ->create([
                'title' => 'Fund 1: DApps & Integrations',
            ]);

        Fund::factory()
            ->create([
                'title' => 'Catalyst F2: DApps & Integrations',
            ]);
        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: Developer ecosystem',
            ]);

        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: DApps & Integrations',
            ]);
        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: Distributed decision making',
            ]);
        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: Proposer outreach',
            ]);
        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: Catalyst value onboarding',
            ]);
        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: Metadata challenge',
            ]);

        Fund::factory()
            ->create([
                'title' => 'Catalyst F5: Grow Africa, Grow Cardano',
            ]);

        Fund::factory()
            ->create([
                'title' => "F5: Scale-UP Cardano's DeFi Ecosystem",
            ]);
    }
}
