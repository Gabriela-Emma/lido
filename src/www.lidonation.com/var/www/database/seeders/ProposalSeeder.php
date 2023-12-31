<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proposal::factory(15)
            ->create();
    }
}
