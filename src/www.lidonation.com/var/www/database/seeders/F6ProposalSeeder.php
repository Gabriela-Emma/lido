<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\Proposal;
use App\Models\Discussion;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Support\Fluent;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class F6ProposalSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws FileCannotBeAdded|InvalidArgumentException
     */
    public function run()
    {
        $path = storage_path().'/json/data/f6/challenges.json';
        $funds = collect(
            json_decode(file_get_contents($path))
        );
        $user = User::where('email', 'hello@lidonation.com')->first();
        $funds->each(function ($f) use ($user) {
            $fund = $this->processFund($f);

            // save proposals
            $path = storage_path()."/json/data/f6/{$f->id}/proposals.json";
            $proposals = Items::fromFile($path);
            foreach ($proposals as $p) {
                $_p = new Fluent($p);
                $updating = Proposal::where('title->en', $_p->title)->first();
                if ((bool) $updating) {
                    ($this->updateProposal($_p, $updating))
                        ->save();

                    continue;
                }

                $proposal = $this->processProposal($_p, $f, 'f6', $fund, $user);

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

                // save reviews
                foreach ($p->f6_assessments as $assessment) {
                    $assessment = new Fluent($assessment);
                    // create ratings
                    $data = [
                        'content' => $assessment->q0,
                        'model_id' => $discussion1->id,
                        'model_type' => Discussion::class,
                        'status' => 'published',
                        'rating' => [
                            'rating' => $assessment->q0r,
                            'status' => 'published',
                        ],
                    ];
                    app(CommentRepository::class)->create($data);

                    $data = [
                        'content' => $assessment->q1,
                        'model_id' => $discussion2->id,
                        'model_type' => Discussion::class,
                        'status' => 'published',
                        'rating' => [
                            'rating' => $assessment->q1r,
                            'status' => 'published',
                        ],
                    ];
                    app(CommentRepository::class)->create($data);

                    $data = [
                        'content' => $assessment->q2,
                        'model_id' => $discussion3->id,
                        'model_type' => Discussion::class,
                        'status' => 'published',
                        'rating' => [
                            'rating' => $assessment->q2r,
                            'status' => 'published',
                        ],
                    ];
                    app(CommentRepository::class)->create($data);
                }
            }
        });
    }
}
