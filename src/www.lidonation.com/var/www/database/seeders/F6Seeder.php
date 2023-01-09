<?php

namespace Database\Seeders;

class F6Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F6ProposalSeeder::class,
            F6ProposalDetailsSeeder::class,
            F6ProposalVotingResultsSeeder::class,
            F6ProposalJaLangSeeder::class,
            F6ProposalUsersSeeder::class,
            F6ProposalFundingReportSeeder::class,
            F6ProposalCleanupSeeder::class,
        ]);
    }
}
