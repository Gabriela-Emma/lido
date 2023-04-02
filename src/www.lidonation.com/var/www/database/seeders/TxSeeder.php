<?php

namespace Database\Seeders;

use App\Models\Tx;
use Illuminate\Database\Seeder;

class TxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tx::factory(5)->create();
    }
}
