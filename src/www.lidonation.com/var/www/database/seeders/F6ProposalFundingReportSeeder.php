<?php

namespace Database\Seeders;

use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F6ProposalFundingReportSeeder extends FSeeder
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
        // save proposals
        $proposals = Items::fromFile(storage_path().'/json/data/f6/funding.json');
        foreach ($proposals as $p) {
            $proposal = $this->processFundingData($p);
            if ((bool) $proposal) {
                $proposal->save();
            }
        }
    }
}
