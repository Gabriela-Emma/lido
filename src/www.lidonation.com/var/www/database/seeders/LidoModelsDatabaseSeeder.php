<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LidoModelsDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            LinkSeeder::class,
            TagSeeder::class,
            ArticlesSeeder::class,
            TeamSeeder::class,
            
            WalletSeeder::class,
            GiveawaySeeder::class,
            EveryEpochSeeder::class,
            QuestionSeeder::class,
            QuizSeeder::class,
            RewardSeeder::class,
            WithdrawalSeeder::class,

            EventSeeder::class,
            TwitterEventSeeder::class,

            PodcastSeeder::class,
            NftSeeder::class,

            RepoSeeder::class,
            CommitSeeder::class,
            LidoMinuteSeeder::class,
            PromoSeeder::class,

        ]);
    }
}
