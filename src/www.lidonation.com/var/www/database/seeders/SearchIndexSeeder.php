<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Assessment;
use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\Group;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Link;
use App\Models\Post;
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
        Group::runCustomIndex();
        Proposal::runCustomIndex();
        Assessment::runCustomIndex();
        Link::runCustomIndex();
    }
}
