<?php

namespace App\Invokables;

use App\Models\Proposal;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
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

//        dd(
//            $this->get_content('http://host.docker.internal:8880/css/catalyst-explorer.css?id=27c293362d21eca17fe479e556768707')
//            Http::get(
//                'http://host.docker.internal:8880/css/catalyst-explorer.css?id=27c293362d21eca17fe479e556768707'
//                asset(mix('css/catalyst-explorer.css'))
//            )->body()
//        );

        $html = view('catalyst-proposal-summary', compact('proposal'))
            ->render();

        $image = Browsershot::html($html)
            ->setChromePath('/usr/bin/chromium-browser')
            ->addChromiumArguments(['no-sandbox'])
            ->noSandbox()
            ->dismissDialogs()
            ->ignoreHttpsErrors()
            ->showBrowserHeaderAndFooter()
            ->setDelay(1000)
            ->setOption('args', ['--disable-web-security'])
            ->emulateMedia('screen')
            ->deviceScaleFactor(1)
            ->waitUntilNetworkIdle();

        $slug = Str::limit($proposal->slug, 36, '');
        if ($save) {
            $locale = $_locale ?? App::currentLocale();
            $path = storage_path("app/images/{$slug}/$locale");

            File::ensureDirectoryExists($path);
            $image->setScreenshotType('jpeg', 100)
                ->windowSize(1306, 1106)

                ->save(
                    "{$path}/{$slug}-cardano-catalyst-proposal-summary-card.jpeg"
                );

            return null;
        }

        return $image;
    }

    protected   function get_content($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }

}
