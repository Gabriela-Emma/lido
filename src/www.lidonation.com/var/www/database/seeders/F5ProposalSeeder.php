<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\Proposal;
use App\Repositories\CommentRepository;
use Illuminate\Support\Fluent;
use JsonMachine\Items;

class F5ProposalSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path().'/json/data/f5/challenges.json';
        $funds = collect(
            json_decode(file_get_contents($path))
        );
        $user = $this->getUser();
        $funds->each(function ($f) use ($user) {
            $fund = $this->processFund($f);

            // save proposals
            $proposals = Items::fromFile(
                storage_path()."/json/data/f5/{$f->id}/proposals.json"
            );
            foreach ($proposals as $p) {
                $_p = new Fluent($p);
                $updating = Proposal::where('title->en', $_p->title)->first();
                if ((bool) $updating) {
                    ($this->updateProposal($_p, $updating))
                        ->save();

                    continue;
                }

                $proposal = $this->processProposal($_p, $f, 'f5', $fund, $user);
                $proposal->created_at = '2021-07-08';
                $proposal->save();

                // save links
                $this->saveLinks($_p, $proposal);

                // save images
                $this->saveImages($_p, $proposal);

                // save videos
                $this->saveVideos($_p, $proposal);

                // create discussions
                $discussion1 = new Discussion;
                $discussion1->title = 'Addresses Challenge';
                $discussion1->content = 'Does the proposal effectively addresses the challenge?';
                $discussion1->model_id = $proposal->id;
                $discussion1->status = 'published';
                $discussion1->model_type = Proposal::class;
                $discussion1->save();

                $discussion2 = new Discussion;
                $discussion2->model_id = $proposal->id;
                $discussion2->model_type = Proposal::class;
                $discussion2->title = 'Feasibility';
                $discussion2->status = 'published';
                $discussion2->content = 'Given experience and plan presented is likely that this proposal will be implemented successfully';
                $discussion2->save();

                $discussion3 = new Discussion;
                $discussion3->model_id = $proposal->id;
                $discussion3->model_type = Proposal::class;
                $discussion3->status = 'published';
                $discussion3->title = 'Auditability';
                $discussion3->content = 'Does the proposal provides sufficient information to assess and audit progress and completion?';
                $discussion3->save();

                $discussion4 = new Discussion;
                $discussion4->model_id = $proposal->id;
                $discussion4->model_type = Proposal::class;
                $discussion4->status = 'published';
                $discussion4->title = 'Impact';
                $discussion4->content = 'The proposal is able to scale to address future challenges.';
                $discussion4->save();

                // save reviews
                foreach ($_p->assessments as $assessment) {
                    $assessment = new Fluent($assessment);
                    if (intval($assessment->question) > 4) {
                        continue;
                    }
                    // create ratings
                    $data = [
                        'content' => $assessment->note,
                        'model_id' => ${'discussion'.$assessment->question}->id,
                        'model_type' => Discussion::class,
                        'status' => 'published',
                        'rating' => [
                            'rating' => $assessment->rating,
                            'status' => 'published',
                        ],
                    ];
                    app(CommentRepository::class)->create($data);
                }
            }
        });
    }
}
