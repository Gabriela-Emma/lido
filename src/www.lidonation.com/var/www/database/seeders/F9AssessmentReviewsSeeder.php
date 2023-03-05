<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\AssessmentReview;
use App\Models\AssessmentReviewsCommentsAssessors;
use App\Models\Assessor;
use App\Services\SettingService;
use Illuminate\Support\Str;
use Revolution\Google\Sheets\Facades\Sheets;

class F9AssessmentReviewsSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(SettingService $settingService): void
    {
        $sheets = Sheets::spreadsheet($settingService->getSettings()?->catalyst_report_vpa_aggregate_file_f9);
        $reportingSheets = collect($sheets->sheetList())->values()->filter(fn ($s) => Str::contains($s, 'vPA Aggregated'));
        foreach ($reportingSheets as $sheet) {
            ($sheets->sheet($sheet)->get())?->each(function ($row) {
                // get first data role
                if (! isset($row[0]) || intval($row[0]) <= 0) {
                    return true;
                }

                if ($row[20] === 'Filtered Out') {
                    return true;
                }
                dispatch(function () use ($row) {
                    $assessor = Assessor::where('assessor_id', $row[4])->first();
                    if (! $assessor instanceof Assessor) {
                        $assessor = new Assessor;
                        $assessor->assessor_id = $row[4];
                        $assessor->save();
                    }

                    // impact
                    $assessment = Assessment::where('content', 'like', Str::words($row[8], 30, '%'))->first();
                    if (! $assessment instanceof Assessment) {
                        return true;
                    }
                    $assessmentReviewSeeder = new static;
                    $assessmentReviewSeeder->createAssessmentReview($row, $assessment, $assessor);

                    // Feasibility
                    $assessment = Assessment::where('content', 'like', Str::words($row[10], 30, '%'))->first();
                    if (! $assessment instanceof Assessment) {
                        return true;
                    }
                    $assessmentReviewSeeder = new static;
                    $assessmentReviewSeeder->createAssessmentReview($row, $assessment, $assessor);

                    // Auditability
                    $assessment = Assessment::where('content', 'like', Str::words($row[12], 30, '%'))->first();
                    if (! $assessment instanceof Assessment) {
                        return true;
                    }

                    $assessmentReviewSeeder = new static;
                    $assessmentReviewSeeder->createAssessmentReview($row, $assessment, $assessor);
                });
            });
        }
    }

    public function createAssessmentReview($row, Assessment $assessment, Assessor $assessor)
    {
        $assessmentReview = AssessmentReview::whereHas('assessments', fn ($q) => $q->where('assessment_id', $assessment->id))->first();
        if (! $assessmentReview instanceof  AssessmentReview) {
            $assessmentReview = new AssessmentReview;
        }

        $assessmentReview->flagged = $row[14];
        $assessmentReview->assessor_id = $assessor?->id;
        $assessmentReview->qa_rationale = $row[15];
        $assessmentReview->excellent_count = $row[16];
        $assessmentReview->good_count = $row[17];
        $assessmentReview->filtered_out_count = $row[18];
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
