<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F4ProposalVotingResultsSeeder extends FSeeder
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
        $proposals = Items::fromFile(storage_path().'/json/data/f4/votes.json');
        foreach ($proposals as $p) {
            $ideascaleParts = explode('/', $p->ideascale_link);
            $ideascaleId = $ideascaleParts[count($ideascaleParts) - 1];

            // save proposal
            $proposal = Proposal::where(
                'ideascale_link',
                'LIKE',
                "%{$ideascaleId}%")
                ->where('title->en', $p->proposal)->first();

            if (isset($proposal)) {
                if ($p->yes_votes_count) {
                    $proposal->yes_votes_count = Str::replace(',', '', $p->yes_votes_count);
                }
                if ($p->no_votes_count) {
                    $proposal->no_votes_count = Str::replace(',', '', $p->no_votes_count);
                }

                if ($p->reason === 'over_budget') {
                    $proposal->status = 'over_budget';
                } else {
                    $proposal->status = strtolower($p->status);
                }

                if ($p->status === 'funded') {
                    $proposal->funded_at = '2021-07-22 12:00:00';
                }

                $proposal->save();

                if ($p->funds_remaining) {
                    $proposal->saveMeta(
                        'funds_remaining',
                        preg_replace('/([^0-9\\.])/i', '', $p->funds_remaining),
                        $proposal,
                        true
                    );
                }
            }
        }
    }
}
