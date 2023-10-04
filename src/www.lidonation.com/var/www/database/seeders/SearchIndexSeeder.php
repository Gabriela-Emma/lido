<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Link;
use App\Models\Post;
use App\Models\Proposal;
use Illuminate\Database\Seeder;

class SearchIndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::runCustomIndex();
        CatalystUser::runCustomIndex();
        CatalystGroup::runCustomIndex();
        Proposal::runCustomIndex();
        Assessment::runCustomIndex();
        Link::runCustomIndex();
    }
}
