<?php

namespace Database\Seeders;

class F4Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F4ProposalSeeder::class,
            //            F4ProposalDetailsSeeder::class,
            F4ProposalVotingResultsSeeder::class,
            //            F5ProposalUsersSeeder::class,
            //            FundFiveProposalSeeder::class,
            //            F5ProposalFundingReportSeeder::class
        ]);
    }
}
