<?php

namespace Database\Seeders;

use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F8ProposalUsersSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     *
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        $users = Items::fromFile(storage_path().'/json/data/f8/users.json');
        foreach ($users as $u) {
            $proposal = $this->getProposalFromIdeascale($u->proposal_url);

            $catalystUser = $this->processAuthor($u);
            $proposal?->users()->syncWithoutDetaching([$catalystUser?->id]);
        }
    }
}
