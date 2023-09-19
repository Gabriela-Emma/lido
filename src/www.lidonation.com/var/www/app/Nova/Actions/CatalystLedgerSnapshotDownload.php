<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class CatalystLedgerSnapshotDownload extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {

            $apiEndpoint = 'https://archiver.projectcatalyst.io/api/v1/archives/'.$model->snapshot_id.'/download';
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
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
