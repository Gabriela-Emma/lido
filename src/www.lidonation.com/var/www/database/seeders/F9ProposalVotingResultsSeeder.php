<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Services\SettingService;
use Revolution\Google\Sheets\Facades\Sheets;

class F9ProposalVotingResultsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(SettingService $settingService)
    {
        // save proposals
        $sheets = Sheets::spreadsheet('1MycQL-dkqf1xEW8xcr7vqcfHY6D7MHnG9ylDKNLSnAA');
        collect($sheets->sheetList())->each(function ($sheetName) use ($sheets) {
            $sheet = $sheets->sheet($sheetName)?->get();
            $sheet->each(function ($row) {
                Proposal::withoutSyncingToSearch(function () use ($row) {
                    //                        0 => "Proposal"
                    //                        1 => "Overall score"
                    //                        2 => "Votes cast"
                    //                        3 => "YES"
                    //                        4 => "NO"
                    //                        5 => "Result"
                    //                        6 => "Meets approval threshold"
                    //                        7 => "REQUESTED $"
                    //                        8 => "STATUS"
                    //                        9 => "FUND DEPLETION"
                    //                        10 => "Reason for not funded status"
                    if (! isset($row[2]) || intval($row[2]) <= 0) {
                        return true;
                    }
                    $proposal = Proposal::where('title->en', $row[0])
                        ->whereHas('fund.parent', fn ($q) => $q->where('id', 97))
                        ->withOut([
                            'fund',
                            'media',
                            'users',
                            'metas',
                        ])->first();

                    if (! $proposal instanceof Proposal) {
                        return true;
                    }
                    $proposal->yes_votes_count = intval(filter_var($row[3], FILTER_SANITIZE_NUMBER_INT));
                    $proposal->no_votes_count = intval(filter_var($row[4], FILTER_SANITIZE_NUMBER_INT));

                    $proposal->funding_status = match ($row[10] ?? null) {
                        'Over Budget' => 'over_budget',
                        'Approval Threshold' => 'not_approved',
                        default => 'funded'
                    };

                    $proposal->status = match ($proposal->funding_status) {
                        'funded' => 'in_progress',
                        default => 'unfunded'
                    };

                    if ($proposal->funding_status === 'funded') {
                        $proposal->funded_at = now();
                    }

                    $proposal->save();
                    $proposal->saveMeta('unique_wallets', $row[2]);
                    $proposal->saveMeta('funds_remaining', preg_replace('/([^0-9\\.])/i', '', $row[9]));

                    return true;
                });
            });
        });
    }
}
