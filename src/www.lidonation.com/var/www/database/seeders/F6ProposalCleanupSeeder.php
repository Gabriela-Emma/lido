<?php

namespace Database\Seeders;

use JsonMachine\Exception\InvalidArgumentException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class F6ProposalCleanupSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws FileCannotBeAdded|InvalidArgumentException
     */
    public function run()
    {
//        $path = storage_path().'/json/fund6/proposer-outreach/proposals.json';
//        $proposals = collect(
//            json_decode(file_get_contents($path))
//        );
//        $proposals->each(function ($p) {
//            $proposal = $this->updateProposal($p);
//            $proposal?->save();
//
//            $this->updateUserBio($proposal);
//        });
    }
}
