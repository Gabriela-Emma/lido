<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\Group;
use Illuminate\Database\Seeder;

class CatalystGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CatalystGroup::factory(3)->create()->each(function ($group) {
        //     $group->members()->saveMany(CatalystLidoUser::factory(3)->make()->all());
        // });
        Group::factory(3)
            ->has(CatalystUser::factory()->count(rand(3, 5)), 'members')
            ->create();
    }
}
