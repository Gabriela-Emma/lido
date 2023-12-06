<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use App\Models\CatalystExplorer\Fund;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateFundDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Fund|int $challenge)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->challenge instanceof Fund) {
            $this->challenge = Fund::find($this->challenge);
        }

        $ideascale_id = $this->challenge->meta_data?->ideascale_id;

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (!$authResponse->successful()) {
            return;
        }

        $response = Http::withToken($authResponse->body())
            ->post(
                'https://cardano.ideascale.com/a/community/api/topbar/campaigns',
                [
                    'limit' => 600,
                    'page' => 0,
                    'term' => '',
                ]
            );

        if (!($response->successful() && count($response->object()?->data?->content))) {
            return;
        }

        $ideascale_Challenge = collect(array_filter(
            collect($response->object()?->data?->content)[0]->campaigns,
            function ($challenge) use ($ideascale_id) {
                return $challenge->id === intval($ideascale_id);
            }
        ))->first();

        $newSyncLink = 'https://cardano.ideascale.com/a/community/api/campaigns/'.$ideascale_id.'/stages/'. $ideascale_Challenge->defaultStage->key.'/ideas/recent/desc';
        $this->challenge->saveMeta('ideascale_sync_link',$newSyncLink,$this->challenge,true);
    }
}
