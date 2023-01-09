<?php

namespace Database\Seeders;

class F8Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F8ProposalSeeder::class,
            F8ProposalDetailsSeeder::class,
            F8ProposalUsersSeeder::class,
            //            F8ProposalLangSeeder::class,
            //            F7ProposalVotingResultsSeeder::class,
            //            F7ProposalFundingReportSeeder::class,
            //            F6ProposalCleanupSeeder::class
        ]);
    }
}
