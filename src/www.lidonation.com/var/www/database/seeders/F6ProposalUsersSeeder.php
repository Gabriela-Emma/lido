<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F6ProposalUsersSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function run()
    {
        $users = Items::fromFile(storage_path().'/json/data/f6/users.json');
        foreach ($users as $u) {
            $proposal = Proposal::where('title->en', $u?->proposal_title)->first();
            $catalystUser = $this->processAuthor($u);
            $proposal?->users()->syncWithoutDetaching([$catalystUser?->id]);
        }
    }
}
