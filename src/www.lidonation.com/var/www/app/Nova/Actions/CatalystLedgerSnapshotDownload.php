<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Http;

class CatalystLedgerSnapshotDownload extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {

            $apiEndpoint = 'https://archiver.projectcatalyst.io/api/v1/archives/'  . $model->snapshot_id . '/download';
            $response = Http::get($apiEndpoint);

            if ($response->successful()) {
                $downloadUrl = $response->json('url');
                $fileName = 'archive.tar.zstd';
                $response = $this->download($downloadUrl, $fileName);
                return $response;
            } else {
                return $this->markAsFailed($model);
            }
        }
    }


    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
