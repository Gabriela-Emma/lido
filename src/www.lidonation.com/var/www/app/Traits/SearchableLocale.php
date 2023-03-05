<?php

namespace App\Traits;

use App\Jobs\MakeSearchableLocaleJob;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Scout;
use Laravel\Scout\Searchable;

trait SearchableLocale
{
    use Searchable;

    protected array $searchableLocales = [];

    // Subbing in the search indexer with debounce/lock feature

    /**
     * Dispatch the job to make the given models searchable.
     *
     * @param  Collection  $models
     * @return void
     */
    public function queueMakeSearchable($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        if (! config('scout.queue')) {
            return $models->first()->searchableUsing()->update($models);
        }

        dispatch((new MakeSearchableLocaleJob($models))
            ->onQueue($models->first()->syncWithSearchUsingQueue())
            ->onConnection($models->first()->syncWithSearchUsing()));

//        dispatch((new Scout::$makeSearchableJob($models))
//            ->onQueue($models->first()->syncWithSearchUsingQueue())
//            ->onConnection($models->first()->syncWithSearchUsing()));
    }

    /**
     * Get the index name for the model.
     */
    public function getSearchableLocales(): array
    {
        return $this->searchableLocales;
    }
}
