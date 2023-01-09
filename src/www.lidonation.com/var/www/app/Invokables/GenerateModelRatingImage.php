<?php

namespace App\Invokables;

use App\Models\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class GenerateModelRatingImage
{
    /**
     * fill default values
     *
     * @param  Model  $review
     * @param  null  $_locale
     * @param  bool  $save
     * @return Browsershot|null
     *
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(Model $review, $_locale = null, bool $save = false): ?Browsershot
    {
        if (isset($_locale)) {
            App::setLocale($_locale);
        }

        $html = view('review-rating-summary', compact('review'))
            ->render();

        $image = Browsershot::html($html)
            ->setChromePath('/usr/bin/chromium-browser')
            ->addChromiumArguments(['no-sandbox'])
            ->emulateMedia('screen')
            ->deviceScaleFactor(3)
            ->waitUntilNetworkIdle();

        if ($save) {
            $locale = App::currentLocale();
            File::ensureDirectoryExists(storage_path("app/images/{$review->slug}/$locale/"));
            $image->setScreenshotType('jpeg', 100)
                ->windowSize(580, 1180)
                ->save(storage_path("app/images/{$review->slug}/$locale/{$review->slug}-cardano-community-review-summary-card-{$review->ratings->count()}.jpeg"));

            return null;
        }

        return $image;
    }
}
