<?php

namespace App\Http\Livewire\Catalyst;

use App\Enums\Ccv4Candidates;
use App\Models\Catalyst\Ccv4BallotChoice;
use App\Models\Snippet;
use App\View\Components\PublicLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

/**
 * to index run php artisan ln:index ln__proposals 'funded,over_budget,challenge,fund'
 */
class CatalystVotesComponent extends Component
{
    public array $snippets = [];

    public $locale = null;

    public $topFundedProposals;
    public $totalResultsByAda;
    public $totalResultsStakeKey;


    public $totalLovelacesBallotPower;
    public $totalAdaBallotPower;
    public $totalLovelaceParticipation;
    public $totalAdaParticipation;
    public $totalVoters;
    public $totalAbstainedVoters;
    public $totalResultsByVotes;
    public $totalCandidatesPerVoter;
    public $adaPowerRanges;


    public function query()
    {
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function mount()
    {
        $this->setLargestAmounts();
        $this->locale = app()->getLocale();
        $this->snippets = Snippet::where('context', 'treasury-dashboard')
            ->orderBy('order')
            ->get()
            ->all();
    }

    public function render(): Factory|View|Application
    {
        app()->setLocale($this->locale);

        return view('livewire.catalyst.votes.votes', (new PublicLayout())->data())
            ->layoutData([
                'metaTitle' => 'Catalyst Reports',
            ]);
    }

    #[NoReturn] protected function setLargestAmounts()
    {
        $this->totalLovelacesBallotPower = Ccv4BallotChoice::sum('voter_power');
        if ($this->totalLovelacesBallotPower > 0) {
            $this->totalAdaBallotPower = humanNumber($this->totalLovelacesBallotPower / 1000000, 2);
        }

        $this->totalLovelaceParticipation = Ccv4BallotChoice::where('ballot_choice_rank', 0)
            ->orWhere('ballot_choice_rank', 1)
            ->sum('voter_power');

        if ($this->totalLovelaceParticipation > 0) {
            $this->totalAdaParticipation = humanNumber($this->totalLovelaceParticipation / 1000000, 2);
        }

        $this->totalResultsByAda = DB::table('ccv4_ballot_choices')
            ->selectRaw('ballot_choice as candidate, SUM(voter_power) as lovelaces')
            ->where('ballot_choice_rank', '!=', 0)
            ->groupBy('candidate')
            ->get()
            ->sortByDesc('lovelaces')
            ->map(function ($ballot) {
                $candidate = Ccv4Candidates::tryFrom($ballot->candidate);
                if ($candidate instanceof Ccv4Candidates) {
                    $ballot->name = $candidate->name();
                    $ballot->ada = humanNumber($ballot->lovelaces / 1000000, 2);
                    $ballot->profile = $candidate->profile();
                }
                return $ballot;
            })->values();

        $this->totalVoters = DB::table('ccv4_ballot_choices')->distinct('voter_id')->count('voter_id');
        $this->totalAbstainedVoters = DB::table('ccv4_ballot_choices')
            ->where('ballot_choice_rank', 0)
            ->distinct('voter_id')
            ->count('voter_id');

        $this->totalResultsByVotes = DB::table('ccv4_ballot_choices')
            ->selectRaw('DISTINCT(COUNT(voter_id)) as votes, ballot_choice as candidate, ballot_choice as candidate')
            ->where('ballot_choice', '>', 0)
            ->groupBy('ballot_choice')->get()
            ->sortByDesc('votes')
            ->map(function ($ballot) {
                $candidate = Ccv4Candidates::tryFrom($ballot->candidate);
                if ($candidate instanceof Ccv4Candidates) {
                    $ballot->name = $candidate->name();
                    $ballot->profile = $candidate->profile();
                }
                return $ballot;
            })->values();

        $this->totalCandidatesPerVoter = DB::table(function ($query) {
            $query->selectRaw('COUNT(voter_id) as candidates')
                ->where('voter_id', '>', 0)
                ->groupBy('voter_id')
                ->from('ccv4_ballot_choices');
        }, 'votes')
            ->selectRaw('COUNT(votes), candidates')
            ->groupBy('candidates')
            ->orderBy('candidates')
            ->get()
            ->map(fn($metric) => ["candidates{$metric->candidates}" => $metric->count])
            ->collapse();

        $agg = DB::table('ccv4_ballot_choices')
            ->selectRaw("CASE
            WHEN voter_power BETWEEN 5000000 AND 10000000 THEN '5-10-1'
            WHEN voter_power BETWEEN 10000000 AND 100000000 THEN '10-100-2'
            WHEN voter_power BETWEEN 100000000 AND 500000000 THEN '100-500-3'
            WHEN voter_power BETWEEN 500000000 AND 1000000000 THEN '500-1k-4'
            WHEN voter_power BETWEEN 1000000000 AND 2500000000 THEN '1k-2.5k-5'
            WHEN voter_power BETWEEN 2500000000 AND 5000000000 THEN '2.5k-5k-6'
            WHEN voter_power BETWEEN 5000000000 AND 10000000000 THEN '5K-10k-7'
            WHEN voter_power BETWEEN 10000000000 AND 25000000000 THEN '10K-25k-8'
            WHEN voter_power BETWEEN 25000000000 AND 50000000000 THEN '25k-50k-9'
            WHEN voter_power BETWEEN 50000000000 AND 75000000000 THEN '50k-75k-10'
            WHEN voter_power BETWEEN 75000000000 AND 100000000000 THEN '75k-100k-11'
            WHEN voter_power BETWEEN 100000000000 AND 250000000000 THEN '100k-250k-12'
            WHEN voter_power BETWEEN 250000000000 AND 500000000000 THEN '250k-500k-13'
            WHEN voter_power BETWEEN 500000000000 AND 750000000000 THEN '500k-750k-14'
            WHEN voter_power BETWEEN 750000000000 AND 1000000000000 THEN '750k-1M-15'
            WHEN voter_power BETWEEN 1000000000000 AND 2000000000000 THEN '1M-2M-16'
            WHEN voter_power BETWEEN 2000000000000 AND 3000000000000 THEN '2M-3M-17'
            WHEN voter_power BETWEEN 3000000000000 AND 4000000000000 THEN '3M-4M-18'
            WHEN voter_power BETWEEN 4000000000000 AND 5000000000000 THEN '4M-5M-19'
            WHEN voter_power BETWEEN 5000000000000 AND 6000000000000 THEN '5M-6M-20'
            WHEN voter_power BETWEEN 6000000000000 AND 7000000000000 THEN '6M-7M-21'
            WHEN voter_power BETWEEN 7000000000000 AND 8000000000000 THEN '7M-8M-22'
            WHEN voter_power BETWEEN 8000000000000 AND 9000000000000 THEN '8M-9M-23'
            WHEN voter_power BETWEEN 9000000000000 AND 10000000000000 THEN '9M-10M-24'
            WHEN voter_power BETWEEN 10000000000000 AND 11000000000000 THEN '10M-11M-25'
            WHEN voter_power BETWEEN 11000000000000 AND 12000000000000 THEN '11M-12M-26'
            WHEN voter_power > 1200000000000 THEN '> 15M'
            WHEN voter_power > 2000000000000 THEN '> 20M'
            END as range,  COUNT(*) as wallets, SUM(voter_power) as ada"
        )->where('ballot_choice_rank', 1)->groupByRaw(1);
        // ada power ranges collection ('range', 'wallets' and ada are the columns)
        $adaPowerRangesCollection = $agg->get()->map(fn($row) => [$row->range => [$row->wallets, $row->ada]])->collapse();

        // convert the collection to an associative array whose structure is fully representative of our front-end needs
        $adaPowerRangesFormattedArray = [];
        foreach ($adaPowerRangesCollection as $range => $value) {
            $rangeArray = explode("-", $range);
            $finalRange = $rangeArray[0] . " - " . $rangeArray[1];

            $adaPowerRangesFormattedArray[$finalRange] = [ $value['0'], round($value['1'] / 1000000, 2), $rangeArray['2']];
        };

        // convert then order the array to collection and assing to the objects $adaPowerRanges property
        $this->adaPowerRanges = collect($adaPowerRangesFormattedArray)->sortBy(function($value, $key) {
            return $value['2'];
        });
    }
}
