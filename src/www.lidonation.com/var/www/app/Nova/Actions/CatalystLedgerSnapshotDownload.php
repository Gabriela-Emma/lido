<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class CatalystLedgerSnapshotDownload extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        foreach ($models as $model) {
            $apiEndpoint = 'https://archiver.projectcatalyst.io/api/v1/archives/'.$model->snapshot_id.'/download';
            $response = Http::get($apiEndpoint);

            if ($response->successful()) {
                $downloadUrl = $response->json('url');
                return Action::download($downloadUrl, "{$model->snapshot_id}.tar.zstd");

//                return ActionResponse::download("{$model->snapshot_id}.tar.zstd", $downloadUrl);
//                return $this->downloadURL("$model->snapshot_id.tar.zstd", $downloadUrl);
//                return Action::redirect($downloadUrl);
            } else {
                return $this->markAsFailed($model);
            }
        }
    }
}
