<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: Developer ecosystem',
                'slug' => 'developer-ecosystem',
            ]);

        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: DApps & Integrations',
                'slug' => 'dapps-integrations',
            ]);
        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: Distributed decision making',
                'slug' => 'distributed-decision-making',
            ]);
        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: Proposer outreach',
                'slug' => 'proposer-outreach',
            ]);
        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: Catalyst value onboarding',
                'slug' => 'catalyst-value-onboarding',
            ]);
        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: Metadata challenge',
                'slug' => 'metadata-challenge',
            ]);

        Tag::factory()
            ->create([
                'title' => 'Catalyst F5: Grow Africa, Grow Cardano',
                'slug' => 'grow-africa-grow-cardano',
            ]);

        Tag::factory()
            ->create([
                'title' => "F5: Scale-UP Cardano's DeFi Ecosystem",
                'slug' => 'scale-up-cardanos-defi-ecosystem',
            ]);

        Tag::factory(25)->create();
    }
}
