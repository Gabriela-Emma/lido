<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use NumberFormatter;

class F3ProposalVotingResultsSeeder extends FSeeder
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
        $proposals = Items::fromFile(storage_path().'/json/data/f3/votes.json');
        $formatter = new NumberFormatter('en_US', NumberFormatter::DEFAULT_STYLE);
        foreach ($proposals as $p) {
            // save proposal
            $slug = Str::slug($p?->proposal);
            $proposal = Proposal::where('slug', "{$slug}-f3")->first();
            if (isset($proposal)) {
                if ($p->yes_votes_count) {
                    $proposal->yes_votes_count = (int) $formatter->parse($p->yes_votes_count);
                }
                if ($p->no_votes_count) {
                    $proposal->no_votes_count = (int) $formatter->parse($p->no_votes_count);
                }

                if ($p->reason === 'over_budget') {
                    $proposal->status = 'over_budget';
                } else {
                    $proposal->status = strtolower($p->status);
                }
                if ($p->status === 'funded') {
                    $proposal->funded_at = '2021-04-18 12:00:00';
                }
                if (isset($p->unique_wallets)) {
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
