<?php

namespace App\Jobs;

use App\Models\Catalyst\Ccv4BallotChoice;
use App\Services\CardanoBlockfrostService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RecordCcv4BallotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected string $tx,
        protected int $blockHeight,
        protected int $blockTime,
    ){}

    /**
     * Execute the job.
     *
     * @param CardanoBlockfrostService $cardanoBlockfrostService
     * @return void
     */
    public function handle(CardanoBlockfrostService $cardanoBlockfrostService): void
    {
        $metadata = $cardanoBlockfrostService->get("txs/{$this->tx}/metadata", null)
            ->collect()?->firstWhere('label', 446);

        $ballots = collect($metadata['json_metadata']);
        $ballots->each(function($ballot) {
            if (empty($ballot['ballot_choices'][0])) {
                $ccv4Ballot = Ccv4BallotChoice::where([
                    'voter_id' => $ballot['voter_id'],
                    'ballot_choice' => -1
                ])->first();
                if (!$ccv4Ballot instanceof  Ccv4BallotChoice) {
                    $ccv4Ballot = new Ccv4BallotChoice;
                    $ccv4Ballot->tx_hash = $this->tx;
                    $ccv4Ballot->block_time = $this->blockHeight;
                    $ccv4Ballot->block_height = $this->blockTime;
                    $ccv4Ballot->voter_id = $ballot['voter_id'];
                    $ccv4Ballot->voter_power = $ballot['voter_power'] * $this->votePower(1);
                    $ccv4Ballot->ballot_id = $ballot['ballot_id'];
                    $ccv4Ballot->ballot_choice = -1;
                    $ccv4Ballot->ballot_choice_rank = 0;
                    $ccv4Ballot->save();
                }
            } else {
                foreach ($ballot['ballot_choices'][0] as $rank => $ballotChoice) {
                    $ccv4Ballot = Ccv4BallotChoice::where([
                        'voter_id' => $ballot['voter_id'],
                        'ballot_choice' => intval($ballotChoice)
                    ])->first();
                    if (!$ccv4Ballot instanceof Ccv4BallotChoice) {
                        $ccv4Ballot = new Ccv4BallotChoice;
                        $ccv4Ballot->tx_hash = $this->tx;
                        $ccv4Ballot->block_time = $this->blockHeight;
                        $ccv4Ballot->block_height = $this->blockTime;
                        $ccv4Ballot->voter_id = $ballot['voter_id'];
                        $ccv4Ballot->voter_power = round($ballot['voter_power'] * $this->votePower($rank + 1) );
                        $ccv4Ballot->ballot_id = $ballot['ballot_id'];
                        $ccv4Ballot->ballot_choice = intval($ballotChoice);
                        $ccv4Ballot->ballot_choice_rank = $rank + 1;
                        $ccv4Ballot->save();
                    } else {
                        Log::info('duplicate ballot', $ccv4Ballot?->toArray());
                    }
                }
            }
        });
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(): array
    {
        return [];
    }

    protected function votePower($rankChoice): float
    {
        return match ($rankChoice) {
            1 => 1.0,
            2 => 0.8,
            3 => 0.6,
            4 => 0.4,
            5 => 0.2,
        };
    }


}
