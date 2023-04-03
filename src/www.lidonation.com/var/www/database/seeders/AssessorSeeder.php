<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Assessor;
use Illuminate\Database\Seeder;

class AssessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assessor::factory()
            ->create();
    }
}
