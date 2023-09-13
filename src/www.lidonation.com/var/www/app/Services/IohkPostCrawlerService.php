<?php

namespace App\Services;

use App\Services\Observers\IohkPostCrawlerObserver;
use GuzzleHttp\RequestOptions;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

class IohkPostCrawlerService
{
    public function __construct(protected $absoluteUrl, protected $lang, protected $baseUrl = 'https://iohk.io')
    {
        $this->fetchContent();
    }

    /**
     * Crawl the website content.
     *
     * @return true
     */
    public function fetchContent()
    {
        // Store a piece of data in the session...
        session(['lang-locale' => $this->lang]);

        //# initiate crawler
        Crawler::create([RequestOptions::ALLOW_REDIRECTS => false, RequestOptions::TIMEOUT => 30])
            ->setCrawlProfile(new CrawlInternalUrls($this->baseUrl))
            ->setParseableMimeTypes(['text/html', 'text/plain'])
            ->setCrawlObserver(new IohkPostCrawlerObserver($this->lang))
            ->setMaximumDepth(0)
            ->setDelayBetweenRequests(100)
            ->startCrawling($this->absoluteUrl);

        return true;
    }
}
