<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\CatalystUser;
use Illuminate\Database\Seeder;

class CatalystUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CatalystUser::factory(10)->create();
    }
}
