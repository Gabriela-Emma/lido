<?php

namespace App\Invokables;

use App\Models\Proposal;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class GenerateProposalImage
{
    /**
     * fill default values
     *
     *
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(Proposal $proposal, $_locale = null, bool $save = false): ?Browsershot
    {
        if (isset($_locale)) {
            App::setLocale($_locale);
        }

        $html = view('catalyst-proposal-summary', compact('proposal'))
            ->render();

        $image = Browsershot::html($html)
            ->setChromePath('/usr/bin/chromium-browser')
            ->addChromiumArguments(['no-sandbox'])
            ->emulateMedia('screen')
            ->deviceScaleFactor(3)
            ->waitUntilNetworkIdle();

        if ($save) {
            $locale = App::currentLocale();
            File::ensureDirectoryExists(storage_path("app/images/{$proposal->slug}/$locale/"));
            $image->setScreenshotType('jpeg', 100)
                ->windowSize(440, 440)
                ->save(
                    storage_path(
                        "app/images/{$proposal->slug}/$locale/{$proposal->slug}-cardano-catalyst-proposal-summary-card.jpeg"
                    )
                );

            return null;
        }

        return $image;
    }
}
