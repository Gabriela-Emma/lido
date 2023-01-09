<?php

namespace App\Jobs;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NumberFormatter;
use Revolution\Google\Sheets\Facades\Sheets;

class CatalystSyncFundingReportFromGSheetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $sheetName)
    {
    }

    /**
     * Execute the job.-
     *
     * @return void
     */
    public function handle(): void
    {
        $sheets = Sheets::spreadsheet(config('services.catalyst.catalyst_reporting_spreadsheet_id'));
        ($sheets->sheet($this->sheetName)->get())?->each(function ($row) {
            // get first data role
            if (! isset($row[1]) || intval($row[1]) <= 0) {
                return true;
            }

            // get amount_received
            if (! isset($row[5])) {
                return true;
            }

            $iogHash = $row[1];
            $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
            $amountReceived = $row[5];
            $curr = 'USD';
            $amountReceived = (int) $formatter->parseCurrency($amountReceived, $curr);

            // get and save proposal
            $proposal = Proposal::whereHas('metas', fn ($q) => $q->where([
                'key' => 'iog_hash',
                'content' => $iogHash,
            ]))->first();

            if (! $proposal) {
                return true;
            }

            $proposal->amount_received = $amountReceived;
            $proposal->funding_updated_at = now();

            $proposal->save();

            return true;
        });
    }
}
