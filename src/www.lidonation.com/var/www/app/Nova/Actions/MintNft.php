<?php

namespace App\Nova\Actions;

use App\Models\Tx;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class MintNft extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Mint Nft';

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Tx $m) {
            try {
                // reset status
                $m->status = 'minting';
                $m->save();

                // mint [again]
                $hash = (new \App\Invokables\MintNft)($m);
                $m->status = 'minted';
                $m->minted_at = now();
                $m->metadata['mint_tx_hash'] = $hash;
                $m->save();
            } catch (\Exception $e) {
                $this->markAsFailed($m, $e);
            }
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
