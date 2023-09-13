<?php

namespace App\Jobs;

use App\Models\Assessment;
use App\Models\Discussion;
use App\Models\Flag;
use App\Models\Proposal;
use App\Repositories\CommentRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SyncF10ReviewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Collection $reviews
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->reviews->each(function ($review) {
            $proposal = Proposal::with('fund')
                ->whereRelation('metas', 'content', $review->proposal_id)
                ->whereRelation('metas', 'key', 'ideascale_id')
                ->first();

            if (! $proposal instanceof Proposal) {
                return;
            }

            if ($proposal->fund?->parent_id !== 113) {
                return;
            }

            $metas = [
                'ranking' => $review->ranking,
                'moderated' => (bool) $review->moderated,
                'allocated' => (bool) $review->allocated,
                'assessor_id' => $review->assessor,
                'assessor_level' => $review->assessor_level,
                'catalyst_record_id' => $review->row_id,
            ];

            $this->createAssessment(
                'Impact Alignment',
                'Has this project clearly demonstrated in all aspects of the proposal that it will positively impact the Cardano Ecosystem?',
                $review->impact_alignment_note,
                $review->impact_alignment_rating_given,
                $metas,
                $proposal,
                $review
            );

            $this->createAssessment(
                'Feasibility',
                'Is this project feasible based on the proposal submitted? Does the plan and associated budget and milestones look achievable? Does the team have the skills, experience, capability and capacity to complete the project successfully?',
                $review->feasibility_note,
                $review->feasibility_rating_given,
                $metas,
                $proposal,
                $review
            );

            $this->createAssessment(
                'Value for money',
                'Is the funding amount requested for this project reasonable and does it provide good Value for Money to the Treasury?',
                $review->auditability_note,
                $review->auditability_rating_given,
                $metas,
                $proposal,
                $review
            );
        });
    }

    protected function createAssessment($discussionTitle, $discussionContent, $assessmentRationale, $assessmentRating, array $metas, Proposal $proposal, $review)
    {
        $existingComment = Assessment::where('content', $assessmentRationale)->first();

        if ($existingComment instanceof Assessment) {
            $existingComment->saveMeta('moderated', $review->ranking, $existingComment);
            $existingComment->saveMeta('ranking', $review->moderated, $existingComment);

            return $existingComment;
        }

        // create discussion
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
            'meta' => $metas,
        ];

        $assessment = Assessment::withoutSyncingToSearch(
            fn () => (app(CommentRepository::class)->create($data))
        );

        // create flags
        $flags = collect($review->flags);
        if ($flags->isNotEmpty()) {
            $flags->each(function ($f) use ($assessment) {
                $flag = new Flag;
                $flag->type = $f['flag_type'];
                $flag->score = $f['score'];
                $flag->model_type = Assessment::class;
                $flag->model_id = $assessment->id;
                $flag->save();
            });
        }
    }

    protected function createDiscussion(string $title, string $content, Proposal $proposal, string $status = 'published'): Discussion
    {
        $discussion = Discussion::where([
            'title' => $title,
            'model_id' => $proposal->id,
            'model_type' => $proposal::class,
        ])->first();

        if ($discussion instanceof Discussion) {
            return $discussion;
        }

        $discussion1 = new Discussion;
        $discussion1->title = $title;
        $discussion1->content = $content;
        $discussion1->model_id = $proposal->id;
        $discussion1->status = $status;
        $discussion1->model_type = $proposal::class;

        return $discussion1;
    }
}
