<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Discussion;
use App\Models\Fund;
use App\Models\Proposal;
use App\Repositories\CommentRepository;
use App\Services\SettingService;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class F9AssessmentsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_vpa_aggregate_file_f9);
        $reportingSheets = collect($sheets->sheetList())->values()->filter(fn ($s) => Str::contains($s, 'Valid assessments'));
        foreach ($reportingSheets as $sheet) {
            ($sheets->sheet($sheet)->get())?->each(function ($row) {
                // get first data role
                if (! isset($row[0]) || intval($row[0]) <= 0) {
                    return true;
                }

                $challenge = Fund::where('title', $row[1])->first();
                if (! $challenge) {
                    return true;
                }

                $proposal = Proposal::where([
                    'fund_id' => $challenge->id,
                    'title->en' => $row[2],
                ])->first();

                if (! $proposal) {
                    return true;
                }

                dispatch(function () use ($row, $proposal) {
                    $seeder = new F9AssessmentsSeeder;
                    $seeder->createAssessment(
                        'Impact / Alignment',
                        'Does the proposal effectively addresses the challenge?',
                        $row[8],
                        $row[9],
                        $proposal,
                        $row
                    );

                    $seeder->createAssessment(
                        'Feasibility',
                        'Given experience and plan presented is likely that this proposal will be implemented successfully?',
                        $row[10],
                        $row[11],
                        $proposal,
                        $row
                    );

                    $seeder->createAssessment(
                        'Auditability',
                        'Does the proposal provides sufficient information to assess and audit progress and completion?',
                        $row[12],
                        $row[13],
                        $proposal,
                        $row
                    );
                });

                return true;
            });
        }
    }

    public function createAssessment($discussionTitle, $discussionContent, $assessmentRationale, $assessmentRating, Proposal $proposal, $row): ?Assessment
    {
        $existingComment = Assessment::where('content', $assessmentRationale)->first();
        if ($existingComment instanceof Assessment) {
            $existingComment->saveMeta('vpa_rating', $row[14], $existingComment);
            $existingComment->saveMeta('assessor_id', $row[4], $existingComment);

            return $existingComment;
        }

        $discussion = $this->createDiscussion(
            $discussionTitle,
            $discussionContent,
            $proposal,
        );
        $discussion->save();
        $data = [
            'content' => $assessmentRationale,
            'model_id' => $discussion->id,
            'model_type' => Discussion::class,
            'status' => 'published',
            'rating' => [
                'rating' => $assessmentRating,
                'status' => 'published',
            ],
            'meta' => [
                'vpa_rating' => $row[14],
                'assessor_id' => $row[4],
            ],
        ];

        return Assessment::withoutSyncingToSearch(fn () => (app(CommentRepository::class)->create($data)));
    }
}
