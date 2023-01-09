<?php

namespace Database\Seeders;

class F3Seeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            F3DAppCreationSeeder::class,
            F3DeveloperEcosystemSeeder::class,
            F3ProposalVotingResultsSeeder::class,
            //            F5ProposalUsersSeeder::class,
        ]);
    }
}
