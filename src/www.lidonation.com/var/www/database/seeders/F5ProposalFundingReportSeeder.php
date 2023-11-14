<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Fluent;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use NumberFormatter;

class F5ProposalFundingReportSeeder extends FSeeder
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
        $proposals = Items::fromFile(storage_path().'/json/data/f5/funding.json');
        foreach ($proposals as $p) {
            $p = new Fluent($p);

            $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
            $curr = 'USD';

            // save proposal
            $proposal = Proposal::where('title->en', $p->title)->first();
            if (isset($proposal)) {
                if ($p->distributed) {
                    $proposal->amount_received = (int) $formatter->parseCurrency($p->distributed, $curr);
                }
                if ($p->status) {
                    $proposal->funding_status = trim(strtolower($p->status));
                }

                $proposal->funding_updated_at = now();

                $proposal->save();
            }
        }
    }
}
