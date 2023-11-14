<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Fluent;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F6ProposalVotingResultsSeeder extends FSeeder
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
        $proposals = Items::fromFile(storage_path().'/json/data/f6/votes.json');
        foreach ($proposals as $p) {
            $p = new Fluent($p);

            // save proposal
            $proposal = Proposal::where('title->en', $p->proposal)->first();
            if (isset($proposal)) {
                if ($p->yes_votes_count) {
                    $proposal->yes_votes_count = preg_replace('/([^0-9\\.])/i', '', $p->yes_votes_count);
                }
                if ($p->no_votes_count) {
                    $proposal->no_votes_count = preg_replace('/([^0-9\\.])/i', '', $p->no_votes_count);
                }

                if ($p->reason === 'over_budget') {
                    $proposal->status = 'over_budget';
                } else {
                    $proposal->status = strtolower($p->status);
                }
                if ($p->status === 'funded') {
                    $proposal->funded_at = '2021-11-29 12:00:00';
                }
                if ($p->unique_wallets) {
                    $proposal->saveMeta('unique_wallets', $p->unique_wallets, $proposal, true);
                }
                if ($p->funds_remaining) {
                    $proposal->saveMeta(
                        'funds_remaining',
                        preg_replace('/([^0-9\\.])/i', '', $p->funds_remaining),
                        $proposal,
                        true
                    );
                }
                $proposal->save();
            }
        }
    }
}
