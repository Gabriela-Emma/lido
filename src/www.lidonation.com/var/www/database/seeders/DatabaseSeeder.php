<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // SearchIndexSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SnippetSeeder::class,
            CategorySeeder::class,
            LinkSeeder::class,
            TagSeeder::class,
            TeamSeeder::class,
            // OnboardingContentSeeder::class,
            //            PostSeeder::class,
            // NewsSeeder::class,
            // InsightsSeeder::class,
            // ReviewsSeeder::class,
            // CommentSeeder::class,
            // CatalystDatabaseSeeder::class
        ]);
    }
}
