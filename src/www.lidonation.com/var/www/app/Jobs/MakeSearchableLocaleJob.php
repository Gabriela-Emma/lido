<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;
use Laravel\Scout\Jobs\MakeSearchable;

class MakeSearchableLocaleJob extends MakeSearchable implements ShouldBeUniqueUntilProcessing
{
    /**
     * Create a new job instance.
     */
    #[Pure]
    public function __construct(Collection $models, public array $locales = ['en', 'es', 'fr', 'sw'])
    {
        parent::__construct($models);
    }

       // Laravel features like "touch" can easily cause a model to be queued for index over and over on repeated updates, this job lock prevents redundant index queueing
       public function uniqueId()
       {
           // Return an md5 hash of the collection ids
           return md5($this->models
               ->map(fn (Model $model) => $model->getMorphClass().':'.$model->getKey())
               ->unique()
               ->sort()
               ->implode(';')
           );
       }

       /**
        * Handle the job.
        *
        * @return void
        */
       public function handle()
       {
           if (count($this->models) === 0) {
               return;
           }

           collect($this->locales)
               ->each(
                   function ($locale) {
                       app()->setLocale($locale);
                       $this->models->first()
                           ->searchableUsing()
                           ->update($this->models);
                   }
               );
       }
}
