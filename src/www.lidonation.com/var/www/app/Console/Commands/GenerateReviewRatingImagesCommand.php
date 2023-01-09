<?php

namespace App\Console\Commands;

use App\Invokables\GenerateModelRatingImage;
use App\Repositories\PostRepository;
use Illuminate\Console\Command;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class GenerateReviewRatingImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:generate-review-summary-images {review}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate summary picture of review.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws CouldNotTakeBrowsershot
     */
    public function handle(PostRepository $postRepository)
    {
        $review = $postRepository->get($this->argument('review'));
        collect(config('laravellocalization.supportedLocales'))
            ->keys()
            ->each(fn ($locale) => (new GenerateModelRatingImage)($review, $locale, true));
    }
}
