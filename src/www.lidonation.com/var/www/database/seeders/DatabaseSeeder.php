<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            // UserSeeder::class,

            SnippetSeeder::class,

            // SearchIndexSeeder::class,

            LidoModelsDatabaseSeeder::class,

            // CatalystDatabaseSeeder::class,
        ]);
    }
}
