<?php

namespace Database\Seeders;

class F7Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F7ProposalSeeder::class,
            F7ProposalLangSeeder::class,
            F7ProposalDetailsSeeder::class,
            F7ProposalVotingResultsSeeder::class,
            F7ProposalUsersSeeder::class,
            F7ProposalFundingReportSeeder::class,
            //            F6ProposalCleanupSeeder::class
        ]);
    }
}
