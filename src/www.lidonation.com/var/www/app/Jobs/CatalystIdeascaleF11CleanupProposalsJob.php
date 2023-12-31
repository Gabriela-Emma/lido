<?php

namespace App\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Services\SettingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\CatalystExplorer\Fund;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\CatalystExplorer\Proposal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\CatalystUpdateProposalDetailsJob;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class CatalystIdeascaleF11CleanupProposalsJob implements ShouldQueue
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
        if (!$this->challenge instanceof Fund) {
            $this->challenge = Fund::find($this->challenge);
        }

        $authResponse = Http::get('https://cardano.ideascale.com/a/community/api/get-token');
        if (!$authResponse->successful()) {
            return;
        }

        $token = $authResponse->body();
        $this->updateDeletedProposals($token);

        $ideascaleProposals = $this->getArchiveProposals($token);
        if ($ideascaleProposals && !empty($ideascaleProposals)) {
            $proposalsToDelete = Proposal::with('metas')->where('fund_id', $this->challenge->id)->whereHas(
                'metas',
                fn ($q) => $q->whereIn('content', $ideascaleProposals)->where('key', 'ideascale_id')
            )->get();
            Log::info('Deleting ' . $proposalsToDelete->count('id') . 'proposals for fund ' . $this->challenge->id);
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
        if (!$url) {
            return [];
        }
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

        if (!$response->successful()) {
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

        if (!$response->successful()) {
            return;
        }

        return collect(
            $response->object()?->data?->content ?? []
        )->pluck('id')->toArray();
    }

    public function updateDeletedProposals($token)
    {
        $url = $this->challenge->meta_data?->ideascale_sync_link;
        if (!$url) {
            return;
        }
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

        if (!$response->successful() || !count($response->object()?->data?->content)) {
            return;
        }

        $ideascaleProposals = collect(
            $response->object()?->data?->content ?? []
        )->pluck('id')->toArray();

        DB::beginTransaction();

        try {
            Proposal::withoutSyncingToSearch(function () use ($ideascaleProposals) {
                $deletedProposals = Proposal::query()->where('fund_id', $this->challenge->id)
                    ->whereHas('metas', function ($query) use ($ideascaleProposals) {
                        $query->where('key', 'ideascale_id')->whereNotIn('content', $ideascaleProposals);
                    })->get();

                foreach ($deletedProposals as $p) {
                    Log::info('Deleting proposal ' . $p->id . ' for fund ' . $this->challenge->id);
                    $p->delete();
                }

                $remainingProposalsCount = Proposal::with('metas')
                    ->where('fund_id', $this->challenge->id)
                    ->count();

                if ($remainingProposalsCount === 0) {
                    throw new \Exception('invalid action');
                }
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
        }
    }
}
