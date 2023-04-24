<?php

namespace Database\Seeders;

use App\Models\LidoMinute;
use Illuminate\Database\Seeder;

class LidoMinuteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LidoMinute::factory(10)->create();
    }
}
