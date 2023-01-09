<?php

namespace Database\Seeders;

class F5Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            F5ProposalSeeder::class,
            F5ProposalDetailsSeeder::class,
            F5ProposalVotingResultsSeeder::class,
            F5ProposalUsersSeeder::class,
            F5ProposalFundingReportSeeder::class,
        ]);
    }
}
