<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: Developer ecosystem',
        //            ]);
        //
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: DApps & Integrations',
        //                'slug' => 'dapps-integrations',
        //            ]);
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: Distributed decision making',
        //            ]);
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: Proposer outreach',
        //            ]);
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: Catalyst value onboarding',
        //            ]);
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: Metadata challenge',
        //            ]);
        //
        //        Category::factory()
        //            ->create([
        //                'title' => 'Catalyst F5: Grow Africa, Grow Cardano',
        //            ]);
        //
        //        Category::factory()
        //            ->create([
        //                'title' => "F5: Scale-UP Cardano's DeFi Ecosystem",
        //            ]);

        Category::factory(15)->create();
    }
}
