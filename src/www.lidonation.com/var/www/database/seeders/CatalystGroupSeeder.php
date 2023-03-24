<?php

namespace Database\Seeders;

use App\Models\CatalystGroup;
use App\Models\CatalystUser;
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
        CatalystGroup::factory(3)->create()->each(function ($group) {
            $group->members()->saveMany(CatalystUser::factory(3)->make()->all());
        });
    }
}
