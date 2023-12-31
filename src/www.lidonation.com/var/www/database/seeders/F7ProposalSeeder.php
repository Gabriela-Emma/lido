<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Support\Fluent;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class F7ProposalSeeder extends FSeeder
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
        $path = storage_path().'/json/data/f7/challenges.json';
        $funds = collect(
            json_decode(file_get_contents($path))
        );
        $user = User::where('email', 'hello@lidonation.com')->first();
        $funds->each(function ($f) use ($user) {
            $fund = $this->processFund($f);
            // save or update proposals
            $path = storage_path()."/json/data/f7/{$f->id}/proposals.json";
            $proposals = Items::fromFile($path);
            foreach ($proposals as $p) {
                $_p = new Fluent($p);
                $proposal = $this->updateProposal($_p);
                if ((bool) $proposal) {
                    $proposal->save();

                    continue;
                }

                $proposal = $this->processProposal($_p, $f, 'f7', $fund, $user);

                // save links
                $this->saveLinks($_p, $proposal);

                // save images
                $this->saveImages($_p, $proposal);

                // save videos
                $this->saveVideos($_p, $proposal);

                // create discussions
                $discussion1 = $this->createDiscussion(
                    'Addresses Challenge',
                    'Does the proposal effectively addresses the challenge?',
                    $proposal,
                );
                $discussion1->save();

                $discussion2 = $this->createDiscussion(
                    'Feasibility',
                    'Given experience and plan presented is likely that this proposal will be implemented successfully?',
                    $proposal,
                );
                $discussion2->save();

                $discussion3 = $this->createDiscussion(
                    'Auditability',
                    'Does the proposal provides sufficient information to assess and audit progress and completion?',
                    $proposal,
                );
                $discussion3->save();

                // save reviews
                foreach ($_p->f6_assessments as $assessment) {
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
