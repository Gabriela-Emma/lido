<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Repositories\CommentRepository;
use Illuminate\Support\Fluent;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class F4ProposalSeeder extends FSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function run()
    {
        $path = storage_path().'/json/data/f4/challenges.json';
        $funds = collect(
            json_decode(file_get_contents($path))
        );
        $user = $this->getUser();
        $funds->each(function ($f) use ($user) {
            $fund = $this->processFund($f);
            // save proposals
            $proposals = Items::fromFile(
                storage_path()."/json/data/f4/{$f->id}/proposals.json"
            );
            foreach ($proposals as $p) {
                $proposal = $this->updateProposal($p);

                if ((bool) $proposal) {
                    $proposal->save();

                    continue;
                }
                $proposal = $this->processProposal($p, $f, 'f4', $fund, $user);
                $proposal->created_at = '2020-02-08';
                $proposal->save();

                // save user
                $catalystUser = $this->processAuthor($p);
                $proposal?->users()->syncWithoutDetaching([$catalystUser?->id]);

                // save links
                $this->saveLinks($p, $proposal);

                // save images
                $this->saveImages($p, $proposal);

                // save videos
                $this->saveVideos($p, $proposal);

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
                foreach ($p->assessments as $assessment) {
                    $assessment = new Fluent($assessment);
                    $question = match ($assessment->question) {
                        4 => 1,
                        5 => 2,
                        6 => 3,
                        default => $assessment->question
                    };

                    if (intval($question) > 3) {
                        continue;
                    }
                    // create ratings
                    $data = [
                        'content' => $assessment->note,
                        'model_id' => ${'discussion'.$question}->id,
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
