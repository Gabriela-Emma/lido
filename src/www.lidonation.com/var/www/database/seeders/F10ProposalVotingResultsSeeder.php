<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Services\SettingService;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class F10ProposalVotingResultsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(SettingService $settingService)
    {
        // save proposals
        $sheets = Sheets::spreadsheet(
            '1HnWOWEehj-ThIyys9Oy-hsjzgI92IDLes0sH0a0zT0A'
        );
        collect($sheets->sheetList())->each(function ($sheetName) use ($sheets) {
            $sheet = $sheets->sheet($sheetName)?->get();
            $sheet->each(function ($row) {
                Proposal::withoutSyncingToSearch(function () use ($row) {
                    //                        0 => "Proposal"
                    //                        1 => "Votes cast"
                    //                        2 => "YES"
                    //                        3 => "NO"
                    //                        4 => "Result"
                    //                        5 => "Meets approval threshold"
                    //                        6 => "REQUESTED $"
                    //                        7 => "STATUS"
                    //                        8 => "FUND DEPLETION"
                    //                        9 => "Reason for not funded status"
                    if (! isset($row[1]) || intval($row[1]) <= 0) {
                        return true;
                    }
                    $slug = Str::limit(Str::slug($row[0]), 150, '').'-'.'f10';
                    $proposal = Proposal::where('slug', $slug )
                        ->whereRelation('fund', 'parent_id', 113)
                        ->withOut([
                            'fund',
                            'media',
                            'users',
                            'metas',
                        ])->first();

                    if (! $proposal instanceof Proposal) {
                        echo 'no result for: ' . $row[0] . PHP_EOL;
                        return true;
                    }
                    $proposal->yes_votes_count = intval(filter_var($row[2], FILTER_SANITIZE_NUMBER_INT));
                    $proposal->no_votes_count = intval(filter_var($row[3], FILTER_SANITIZE_NUMBER_INT));

                    $proposal->funding_status = match ($row[9] ?? null) {
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
                    $proposal->saveMeta('unique_wallets', $row[1]);
                    if (isset($row[8])) {
                        $proposal->saveMeta('funds_remaining', preg_replace('/([^0-9\\.])/i', '', $row[8]));
                    }
                    return true;
                });
            });
        });
    }
}
