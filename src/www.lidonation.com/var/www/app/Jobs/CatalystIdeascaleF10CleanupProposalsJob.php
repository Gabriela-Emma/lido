<?php

namespace App\Jobs;

use App\Models\Fund;
use App\Models\Proposal;
use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class CatalystIdeascaleF10CleanupProposalsJob implements ShouldQueue
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
    public function handle(SettingService $settingService): void
    {
        if (! $this->challenge instanceof Fund) {
            $this->challenge = Fund::find($this->challenge);
        }

        $ideascaleId = $this->challenge->meta_data->ideascale_id;

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (! $authResponse->successful()) {
            return;
        }

        $url = Str::replace('{$ideascaleId}', $ideascaleId, $settingService->getSettings()?->catalyst_f10_ideascale_archive_link);
        $response = Http::withToken($authResponse->body())
            ->post(
                $url,
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
            $proposal = Proposal::whereRelation('metas', [
                'key' => 'ideascale_id',
                'content' => $proposal->id,
            ])->first();

            if ($proposal instanceof Proposal) {
                $proposal->forceDelete();
            }
        }
    }

}
