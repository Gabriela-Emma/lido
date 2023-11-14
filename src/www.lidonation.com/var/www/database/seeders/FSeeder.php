<?php

namespace Database\Seeders;

use App\Models\CatalystExplorer\CatalystUser;
use App\Models\CatalystExplorer\Fund;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Discussion;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use NumberFormatter;

class FSeeder extends Seeder
{
    protected function getUser()
    {
        return User::where('email', 'hello@lidonation.com')->first();
    }

    protected function saveVideos(&$p, &$proposal)
    {
        if (isset($p->videos)) {
            foreach ($p->videos as $video) {
                if (Str::contains($video, ['youtube', 'yt.'])) {
                    $proposal->saveMeta('youtube', $video, $proposal);
                } elseif (Str::contains($video, ['vimeo'])) {
                    $proposal->saveMeta('vimeo', $video, $proposal);
                } else {
                    $proposal->saveMeta('video', $video, $proposal);
                }
            }
        }
    }

    protected function saveImages(&$p, &$proposal)
    {
        $catalystMedia = [];
        if ($p->media) {
            foreach ($p->media as $media) {
                $media = new Fluent($media);
                if (Str::contains($media->title, 'video')) {
                    $proposal->saveMeta('video', $media->url, $proposal);
                } elseif (Str::contains($media->url, 'cardano.ideascale')) {
                    $catalystMedia[] = $media->url;
                } else {
                    $proposal->addMediaFromUrl($media->url)->withCustomProperties([
                        'title' => $media->title,
                    ])->toMediaCollection('hero');
                }
            }
        }
        if (! empty($catalystMedia)) {
            $proposal->saveMeta('ideascale_media', json_encode($catalystMedia), $proposal);
        }
    }

    protected function saveLinks(&$p, &$proposal)
    {
        $link = $this->createLink($p->url);
        $link->save();
        $proposal->links()->attach($link->id, [
            'model_type' => Proposal::class,
        ]);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function processProposal(&$p, &$challenge, $folder, &$fund, &$user): Proposal
    {
        $p = $this->getFluentProposal($p, $folder, $challenge);
        $proposal = Proposal::where([
            'title->en' => $p->proposal ?? $p->title,
            'fund_id' => $fund?->id,
        ])->first();

        // save Proposal
        if (! $proposal) {
            $proposal = $this->createProposal($p);
        }
        $proposal->user_id = $user?->id;
        $proposal->fund_id = $fund?->id;

        $proposal->save();

        $proposal->saveMeta('ideascale_id', $p->id);

        return $proposal;
    }

    protected function processFundingData($p)
    {
        $p = new Fluent($p);

        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $curr = 'USD';

        // save proposal
        $proposal = Proposal::where('title->en', $p->title)->first();
        if (isset($proposal)) {
            if ($p->distributed) {
                $proposal->amount_received = (int) $formatter->parseCurrency($p->distributed, $curr);
            }
            if ($p->status) {
                $proposal->funding_status = trim(strtolower($p->status));
            }

            $proposal->funding_updated_at = now();

            return $proposal;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function processAuthor(&$user): ?CatalystUser
    {
        $parts = explode('@', $user->author);
        $cu = CatalystUser::where('username', $parts[count($parts) - 1])->first();
        // save CatalystLidoUser
        if (! $cu) {
            $cu = $this->createCatalystUser($user);
        } else {
            $cu->name = $parts[0];
        }
        $cu->save();

        return $cu;
    }

    protected function processFund(&$f): Fund
    {
        $fund = Fund::where('title', $f->title)->first();
        if ((bool) $fund) {
            return $fund;
        }
        $fund = $this->createFund($f);
        $fund->save();
        $fund->saveMeta('ideascale_id', $f->id, $fund);
        $link = $this->createLink($f->url);
        $link->save();
        $fund->links()->attach($link->id, [
            'model_type' => Fund::class,
        ]);

        return $fund;
    }

    protected function createLink($url, $title = 'Ideascale Link'): Link
    {
        $link = new Link;
        $link->type = 'link';
        $link->status = 'published';
        $link->label = 'registration required';
        $link->title = $title;
        $link->link = $url;
        $link->valid = true;

        return $link;
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

    protected function createFund($f): Fund
    {
        $fund = new Fund;
        $fund->title = $f?->title ?? null;
        $fund->content = $f?->description ?? null;
        $fund->amount = floatval($f?->amount ?? null);

        return $fund;
    }

    protected function createCatalystUser($p): ?CatalystUser
    {
        $parts = explode('@', $p->author);
        $data = [
            'name' => $parts[0],
        ];
        if (isset($parts[1])) {
            $data['username'] = $parts[1];
        }

        return CatalystUser::updateOrCreate(
            [
                'name' => $parts[0],
            ],
            $data
        );
    }

    protected function createProposal($p): Proposal
    {
        $proposal = new Proposal;
        $proposal->title = Str::remove('\n', $p?->title ?? null);
        $proposal->slug = Str::slug($p?->title);
        $proposal->problem = trim($p?->description ?? $p?->problem ?? null);
        $proposal->solution = trim($p?->solution ?? $p?->problem_solution ?? null);
        $proposal->experience = trim($p?->experience ?? $p?->relevant_experience ?? null);
        $proposal->amount_requested = floatval($p?->amount ?? $p?->requested_funds ?? null);
        $proposal->created_at = $p?->created_at ?? null;
        $proposal->ideascale_link = $p?->url ?? null;
        $proposal->content = trim($p?->content ?? null);
        $proposal->definition_of_success = $p->definition_of_success ?? $p->outcomeObjectives ?? null;
        $proposal->status = 'pending';

        return $proposal;
    }

    protected function updateProposal($p): ?Proposal
    {
        $title = strval($p->proposal ?? $p->title);
        $title = explode("\n", $title)[0];
        $proposal = Proposal::where([
            'title->en' => $title,
            'amount_requested' => $p->amount,
        ])->has('discussions')->get()->first();

        if ((bool) $proposal) {
            if (! $proposal->website) {
                $proposal->website = $p?->website ?? null;
            }

            if (! $proposal->problem) {
                $proposal->problem = $p?->description ?? null;
            }

            if (! $proposal->solution) {
                $proposal->solution = $p?->solution ?? null;
            }

            if (! $proposal->experience) {
                $proposal->experience = $p?->experience ?? null;
            }

            if (! $proposal->content) {
                $proposal->content = $p?->content ?? null;
            }

            if (! $proposal->amount_requested) {
                $proposal->amount_requested = $p?->amount ?? null;
            }

            if (! $proposal->ideascale_link) {
                $proposal->ideascale_link = $p?->url ?? null;
            }

            if (! $proposal->definition_of_success) {
                $proposal->definition_of_success = $p->definition_of_success ?? $p->outcomeObjectives ?? null;
            }
        }

        return $proposal;
    }

    protected function getProposalFromIdeascale($proposal_url): ?Proposal
    {
        $ideascaleParts = explode('/', $proposal_url);
        $ideascaleId = $ideascaleParts[count($ideascaleParts) - 1];

        return Proposal::where(
            'ideascale_link',
            'LIKE',
            "%{$ideascaleId}-%"
        )->get()?->first();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function getFluentProposal(&$p, &$folder, &$challenge): Fluent
    {
        if (! is_object($p)) {
            return new Fluent($p);
        }

        $path = storage_path()."/json/data/{$folder}/{$challenge->id}/proposals/{$p->id}.json";

        return new Fluent(Items::fromFile($path));
    }
}
