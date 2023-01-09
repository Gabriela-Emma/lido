<?php

namespace Database\Seeders;

use App\Models\CatalystUser;
use App\Models\Link;
use App\Models\Post;
use App\Models\Proposal;
use Illuminate\Database\Seeder;

class SearchIndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Post::runCustomIndex();
        CatalystUser::runCustomIndex();
        Proposal::runCustomIndex();
        Link::runCustomIndex();
    }
}
