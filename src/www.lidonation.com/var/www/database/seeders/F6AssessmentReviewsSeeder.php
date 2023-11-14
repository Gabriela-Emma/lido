<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Assessment;
use App\Models\CatalystExplorer\AssessmentReview;
use App\Models\CatalystExplorer\AssessmentReviewsCommentsAssessors;
use App\Models\CatalystExplorer\Assessor;
use App\Services\SettingService;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class F6AssessmentReviewsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_vca_aggregate_file_f6);
        $reportingSheets = collect($sheets->sheetList())->values()->filter(fn ($s) => Str::contains($s, 'vCA Aggregated'));
        foreach ($reportingSheets as $sheet) {
            ($sheets->sheet($sheet)->get())?->each(function ($row) {
                // get first data role
                if (! isset($row[0]) || intval($row[0]) <= 0) {
                    return true;
                }

                if ($row[18] === 'x') {
                    return true;
                }

                dispatch(function () use ($row) {
                    $assessmentReviewSeeder = new static;
                    $assessor = Assessor::where('assessor_id', $row[3])->first();
                    if (! $assessor instanceof Assessor) {
                        $assessor = new Assessor;
                        $assessor->assessor_id = $row[3];
                        $assessor->save();
                    }

                    // impact
                    $assessment = Assessment::where('content', 'like', Str::words($row[4], 40, '%'))->first();
                    if ($assessment instanceof Assessment) {
                        $assessmentReviewSeeder->createAssessmentReview($row, $assessment, $assessor);
                    }

                    // Feasibility
                    $assessment = Assessment::where('content', 'like', Str::words($row[6], 40, '%'))->first();
                    if ($assessment instanceof Assessment) {
                        $assessmentReviewSeeder->createAssessmentReview($row, $assessment, $assessor);
                    }

                    // Auditability
                    $assessment = Assessment::where('content', 'like', Str::words($row[8], 40, '%'))->first();
                    if ($assessment instanceof Assessment) {
                        $assessmentReviewSeeder->createAssessmentReview($row, $assessment, $assessor);
                    }
                });
            });
        }
    }

    public function createAssessmentReview($row, Assessment $assessment, Assessor $assessor)
    {
        $assessmentReview = AssessmentReview::whereHas('assessments', fn ($q) => $q->where('assessment_id', $assessment->id))->first();
        if (! $assessmentReview instanceof AssessmentReview) {
            $assessmentReview = new AssessmentReview;
        }

        $assessmentReview->flagged = $row[10] == 'x';
        $assessmentReview->assessor_id = $assessor?->id;
        $assessmentReview->qa_rationale = $row[11];
        $assessmentReview->excellent_count = $row[12];
        $assessmentReview->good_count = $row[13];
        $assessmentReview->filtered_out_count = $row[14];
        $assessmentReview->save();

        $assessmentReviewComment = AssessmentReviewsCommentsAssessors::where([
            'assessor_id' => $assessor->id,
            'assessment_id' => $assessment->id,
            'assessment_review_id' => $assessmentReview->id,
        ])->first();
        if ($assessmentReviewComment instanceof AssessmentReviewsCommentsAssessors) {
            return true;
        }

        $assessmentReviewComment = new AssessmentReviewsCommentsAssessors;
        $assessmentReviewComment->assessor_id = $assessor->id;
        $assessmentReviewComment->assessment_id = $assessment->id;
        $assessmentReviewComment->assessment_review_id = $assessmentReview->id;
        $assessmentReviewComment->save();
    }
}
