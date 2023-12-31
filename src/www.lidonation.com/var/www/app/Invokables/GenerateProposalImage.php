<?php

namespace App\Invokables;

use App\Models\CatalystExplorer\Proposal;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
            ->noSandbox()
            ->dismissDialogs()
            ->ignoreHttpsErrors()
            ->timeout(300)
            ->showBrowserHeaderAndFooter()
            ->setOption('args', ['--disable-web-security'])
            ->emulateMedia('screen')
            ->deviceScaleFactor(2)
            ->waitUntilNetworkIdle();

        $slug = Str::limit($proposal->slug, Proposal::$previewImageNameLength, '');
        if ($save) {
            $locale = $_locale ?? App::currentLocale();
            $path = storage_path("app/images/{$slug}/$locale");

            File::ensureDirectoryExists($path);
            $image->setScreenshotType('jpeg', 100)
                ->windowSize(520, 320)
                ->save(
                    "{$path}/{$slug}-cardano-catalyst-proposal-summary-card.jpeg"
                );

            return null;
        }

        return $image;
    }
}
