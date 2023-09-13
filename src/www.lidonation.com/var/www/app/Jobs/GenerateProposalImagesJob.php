<?php

namespace App\Jobs;

use App\Invokables\GenerateProposalImage;
use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class GenerateProposalImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Proposal $proposal)
    {
    }

    /**
     * Execute the job
     *
     * @return void
     *
     * @throws CouldNotTakeBrowsershot
     */
    public function handle(): void
    {
        collect(config('laravellocalization.supportedLocales'))->keys()
            ->each(fn ($locale) => (new GenerateProposalImage)($this->proposal, $locale, true));
    }
}
