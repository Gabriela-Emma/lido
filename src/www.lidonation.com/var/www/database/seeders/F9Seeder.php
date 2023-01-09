<?php

namespace Database\Seeders;

class F9Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F9ProposalDetailsSeeder::class,
            //            F8ProposalUsersSeeder::class,
            //            F8ProposalLangSeeder::class,
            //            F7ProposalVotingResultsSeeder::class,
            //            F7ProposalFundingReportSeeder::class,
            //            F6ProposalCleanupSeeder::class
        ]);
    }
}
