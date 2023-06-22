<?php

namespace App\Jobs;

use App\Models\Fund;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class CatalystIdeascaleF10SyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Fund|int $challenge)
    {
    }

    /**
     * Execute the job.
     *
     *
     * @throws FileCannotBeAdded
     */
    public function handle(): void
    {
        if (! $this->challenge instanceof Fund) {
            $this->challenge = Fund::find($this->challenge);
        }

        $ideascaleId = $this->challenge->meta_data->ideascale_id;

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (! $authResponse->successful()) {
            return;
        }

        $response = Http::withToken($authResponse->body())
            ->post(
                "https://cardano.ideascale.com/a/community/api/campaigns/{$ideascaleId}/stages/all/ideas/recent/desc",
                [
                    'tag' => '',
                    'labelKey' => '',
                    'applicableIdeasOnly' => false,
                    'moderatorTag' => '',
                    'pageParameters' => [
                        'limit' => 600,
                        'page' => 0,
                    ],
                ]
            );

        if (! $response->successful()) {
            return;
        }

        $proposals = $response->object()?->data?->content ?? [];

        foreach($proposals as $proposal) {
            $p = $this->processProposal($proposal);
            dispatch(new CatalystUpdateProposalDetailsJob($p));
        }
    }

    protected function processProposal(&$data): Proposal
    {
        $proposal = Proposal::whereRelation('metas', [
            'key' => 'ideascale_id',
            'content' => $data->id,
        ])->first();

        if (!$proposal instanceof Proposal) {
            $proposal = new Proposal;
            $proposal->title = $data->title;
            $proposal->status = 'pending';
            $proposal->funding_status = 'pending';
            $proposal->fund_id = $this->challenge?->id;
            $proposal->ideascale_link = "https://cardano.ideascale.com/c/idea/{$data->id}";
            $proposal->slug = Str::slug($proposal->title);
            $proposal->save();
            $proposal->saveMeta('ideascale_id', $data->id);
        }

        return $proposal;
    }

}
