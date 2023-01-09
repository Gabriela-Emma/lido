<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\Fund;
use App\Models\LegacyComment;
use App\Models\Proposal;
use App\Repositories\CommentRepository;
use App\Services\SettingService;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class F8AssessmentsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @param  SettingService  $settingService
     * @return void
     */
    public function run(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_vca_aggregate_file_f8);
        $reportingSheets = collect($sheets->sheetList())->values()->filter(fn ($s) => Str::contains($s, 'Valid Assessments'));
        foreach ($reportingSheets as $sheet) {
            ($sheets->sheet($sheet)->get())?->each(function ($row) {
                // get first data role
                if (! isset($row[0]) || intval($row[0]) <= 0) {
                    return true;
                }

                $challenge = Fund::where('title', $row[2])->first();
                if (! $challenge) {
                    return true;
                }

                $proposal = Proposal::where([
                    'fund_id' => $challenge->id,
                    'title->en' => $row[1],
                ])->first();

                if (! $proposal) {
                    return true;
                }

                dispatch(function () use ($row, $proposal) {
                    $seeder = new F8AssessmentsSeeder;
                    $seeder->createAssessment(
                        'Impact / Alignment',
                        'Does the proposal effectively addresses the challenge?',
                        $row[6],
                        $row[7],
                        $proposal,
                        $row
                    );

                    $seeder->createAssessment(
                        'Feasibility',
                        'Given experience and plan presented is likely that this proposal will be implemented successfully?',
                        $row[8],
                        $row[9],
                        $proposal,
                        $row
                    );

                    $seeder->createAssessment(
                        'Auditability',
                        'Does the proposal provides sufficient information to assess and audit progress and completion?',
                        $row[10],
                        $row[11],
                        $proposal,
                        $row
                    );
                });

                return true;
            });
        }
    }

    public function createAssessment($discussionTitle, $discussionContent, $assessmentRationale, $assessmentRating, Proposal $proposal, $row): ?LegacyComment
    {
        $existingComment = LegacyComment::where('content', $assessmentRationale)->first();
        if ($existingComment instanceof LegacyComment) {
            $existingComment->saveMeta('vpa_rating', $row[12] == 'x' ? 'Excellent' : 'Good', $existingComment);
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
                'vpa_rating' => $row[12] == 'x' ? 'Excellent' : 'Good',
                'assessor_id' => $row[5],
            ],
        ];

        return LegacyComment::withoutSyncingToSearch(fn () => (app(CommentRepository::class)->create($data)));
    }
}
