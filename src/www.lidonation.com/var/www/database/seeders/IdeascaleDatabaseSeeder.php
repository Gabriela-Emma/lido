<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IdeascaleDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F5ProposalSeeder::class,
            F5ProposalDetailsSeeder::class,
            F5ProposalVotingResultsSeeder::class,

            F6ProposalSeeder::class,
            F6ProposalDetailsSeeder::class,
            F6ProposalJaLangSeeder::class,
            F6ProposalVotingResultsSeeder::class,

            F7ProposalSeeder::class,
            F7ProposalLangSeeder::class,
            F7ProposalVotingResultsSeeder::class,
        ]);
    }
}
