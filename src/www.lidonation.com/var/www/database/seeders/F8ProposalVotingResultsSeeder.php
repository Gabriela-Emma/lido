<?php

namespace Database\Seeders;

use App\Models\Proposal;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F8ProposalVotingResultsSeeder extends FSeeder
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
        $proposals = Items::fromFile(storage_path().'/json/data/f8/votes.json');
        foreach ($proposals as $p) {
            Proposal::withoutSyncingToSearch(function () use ($p) {
                $proposal = Proposal::where('title->en', $p->proposal)
                    ->whereHas('fund.parent', fn ($q) => $q->where('id', 61))
                    ->withOut([
                        'fund',
                        'media',
                        'users',
                        'metas',
                    ])
                    ->first();

                if (isset($proposal)) {
                    if ($p->yes_votes_count) {
                        $proposal->yes_votes_count = $p->yes_votes_count;
                    }
                    if ($p->no_votes_count) {
                        $proposal->no_votes_count = $p->no_votes_count;
                    }

                    $p->funding_status = match ($p->reason) {
                        'over_budget' => 'over_budget',
                        'unfunded' => 'not_approved',
                        default => strtolower($p->status)
                    };
                    $p->status = match($proposal->status) {
                        'funded' => 'in_progress',
                        default => 'unfunded'
                    };

                    if ($p->status === 'funded') {
                        $proposal->funded_at = now();
                    }
                    $proposal->save();
                    if ($p->unique_wallets) {
                        $proposal->saveMeta('unique_wallets', $p->unique_wallets);
                    }
                    if ($p->funds_remaining) {
                        $proposal->saveMeta('funds_remaining', preg_replace('/([^0-9\\.])/i', '', $p->funds_remaining));
                    }
                }
            });
        }
    }
}
