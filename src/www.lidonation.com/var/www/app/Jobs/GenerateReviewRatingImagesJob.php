<?php

namespace App\Jobs;

use App\Invokables\GenerateModelRatingImage;
use App\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class GenerateReviewRatingImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Model $model)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws CouldNotTakeBrowsershot
     */
    public function handle()
    {
        collect(config('laravellocalization.supportedLocales'))->keys()
            ->each(fn ($locale) => (new GenerateModelRatingImage)($this->model, $locale, true));
    }
}
