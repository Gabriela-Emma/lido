<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LidoModelsDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // CategorySeeder::class,
            LinkSeeder::class,
            TagSeeder::class,

            ArticlesSeeder::class,

            LidoEarnLearnDatabaseSeeder::class,

            TeamSeeder::class,

            WalletSeeder::class,
            GiveawaySeeder::class,

            EveryEpochSeeder::class,
            QuestionSeeder::class,
            QuizSeeder::class,

            RewardSeeder::class,
            WithdrawalSeeder::class,

            //            EventSeeder::class,
            //            TwitterEventSeeder::class,

            //    LidoMinuteSeeder::class,

            PodcastSeeder::class,
            NftSeeder::class,

            RepoSeeder::class,
            CommitSeeder::class,

            PromoSeeder::class,
            MintSeeder::class,
        ]);
    }
}
