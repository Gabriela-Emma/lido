<?php

namespace App\Nova\Actions;

use App\Jobs\SyncVotingPowersFileJob;
use App\Models\CatalystSnapshot;
use App\Models\CatalystVotingPower;
use App\Models\Fund;
use App\Models\Meta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File as FileField;
use Illuminate\Support\Facades\File;
use Laravel\Nova\Http\Requests\NovaRequest;

class ImportVotingPower extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Import Voting Powers';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (CatalystSnapshot $snapshot) use($fields) {
            try {
                $fund = Fund::find($snapshot->model_id);
                
                $directory = 'catalyst_snapshots';
                $storageDirectory = storage_path('app/public/'.$directory);
                $fileName = 'catalyst-snapshot-'.$fund->slug .'.'. $fields->file->getClientOriginalExtension();
                $storagePath = 'app/public/catalyst_snapshots/' . $fileName;
                $fullFilePath = $storageDirectory . '/' . $fileName;

                //save then format the file
                $fields->file->move($storageDirectory, $fileName);
                $this->formatCSV($fullFilePath, $storagePath);

                //delete existing snapshot records
                $this->deleteExistingRecords($snapshot);

                //save snapshot's metadata about file
                $this->saveSnapshotMeta($snapshot, $directory, $fileName);

                $header = $this->getFirstLine($storagePath);
                SyncVotingPowersFileJob::dispatch($snapshot, $fullFilePath, $header);

            } catch (\Exception $e) {
                $this->markAsFailed($snapshot, $e);
            }
        });
    }

    protected function deleteExistingRecords(CatalystSnapshot $snapshot)
    {
        //delete file details metadata
        $metaData = Meta::where('key', 'snapshot_file_path')
            ->where('model_type', CatalystSnapshot::class)
            ->where('model_id', $snapshot->id);
        $metaData->delete();

        //delete related voting powers
        $powers = CatalystVotingPower::where('catalyst_snapshot_id', $snapshot->id);
        $powers->delete();
    }

    protected function saveSnapshotMeta(CatalystSnapshot $snapshot, $directory, $fileName)
    {
        $meta = new Meta();
        $meta->model_type = CatalystSnapshot::class;
        $meta->model_id = $snapshot->id;
        $meta->key = 'snapshot_file_path';
        $meta->content = $directory . '/' . $fileName;

        $meta->save();
    }

    protected function formatCSV($fullPath, $storagePath)
    {
        $expectedHeaders = ['stake_address', 'voting_power'];
        $csvHeaders = $this->getFirstLine($storagePath);

        if ($expectedHeaders !== $csvHeaders) {
            // if either is numeric then no header is provided
            if (is_numeric($csvHeaders[0]) || is_numeric($csvHeaders[1])) {
                $header = is_numeric($csvHeaders[1]) ? "stake_address,voting_power\n" : "voting_power,stake_address\n";
                File::prepend($fullPath, $header);
            } else {
                // remove the current headers that dont conform
                $lines = $this->getFileLines($storagePath);
                array_shift($lines);
                $newFileContents = implode("\n", $lines);
                Storage::put($storagePath, $newFileContents);
        
                // read the file again and add headers based on column arrangements
                $csvHeaders = $this->getFirstLine($storagePath);
        
                $header = is_numeric($csvHeaders[1]) ? "stake_address,voting_power\n" : "voting_power,stake_address\n";
                File::prepend($fullPath, $header);
            }
        }
    }

    protected function getFirstLine($filePath)
    {
        $lines = $this->getFileLines($filePath);

        return str_getcsv($lines[0]);
    }

    protected function getFileLines($filePath)
    {
        $file = file_get_contents(storage_path($filePath));
        $lines = explode("\n", $file);

        return $lines;
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            FileField::make('Voting Power Snapshot', 'file')
        ];
    }
}
