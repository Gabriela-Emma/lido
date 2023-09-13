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
use Illuminate\Support\Facades\Log;
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

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (! $authResponse->successful()) {
            return;
        }

        $token = $authResponse->body();
        // $ideascaleProposls = array_merge(
        //     $this->getActiveProposals($settingService, $ideascaleId, $token),
        //     $this->getArchiveProposals($settingService, $ideascaleId, $token)
        // );
        $ideascaleProposls = $this->getArchiveProposals($token);
        if ($ideascaleProposls && ! empty($ideascaleProposls)) {
            $proposalsToDelete = Proposal::with('metas')->where('fund_id', $this->challenge->id)->whereHas(
                'metas',
                fn ($q) => $q->whereIn('content', $ideascaleProposls)->where('key', 'ideascale_id')
            )->get();

            Log::info('Deleting '.$proposalsToDelete->count('id').'proposals for fund '.$this->challenge->id);
            if ($proposalsToDelete->isNotEmpty()) {
                $proposalsToDelete->each(
                    fn ($proposal) => $proposal->delete()
                );
            }
        }
    }

    protected function getArchiveProposals($token)
    {
        $url = $this->challenge->meta_data?->ideascale_archive_link;
        $response = Http::withToken($token)
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
            return [];
        }

        return collect(
            $response->object()?->data?->content ?? []
        )->pluck('id')->toArray();
    }

    protected function getActiveProposals($token)
    {
        // $url = Str::replace('{$ideascaleId}', $ideascaleId, $settingService->getSettings()?->catalyst_f10_ideascale_sync_link);
        $url = $this->challenge->meta_data?->ideascale_sync_link;
        $response = Http::withToken($token)
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
            return [];
        }

        return collect(
            $response->object()?->data?->content ?? []
        )->pluck('id')->toArray();
    }
}
