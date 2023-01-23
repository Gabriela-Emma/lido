<?php

namespace App\Services;

use App\Services\Observers\IohkPostCrawlerObserver;
use Illuminate\Http\Request;
use App\Observers\CustomCrawlerObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\Crawler;
use GuzzleHttp\RequestOptions;

class IohkPostCrawlerService
{

    public function __construct() {}  
    
    /**
     * Crawl the website content.
     * @return true
     */
    public function fetchContent(string $postLink){
        //# initiate crawler 
        Crawler::create([RequestOptions::ALLOW_REDIRECTS => false, RequestOptions::TIMEOUT => 30])
        ->setCrawlProfile(new CrawlInternalUrls('https://iohk.io'))
        ->setParseableMimeTypes(['text/html', 'text/plain'])
        ->setCrawlObserver(new IohkPostCrawlerObserver())
        ->setMaximumDepth(0)
        ->setDelayBetweenRequests(100)
        ->startCrawling($postLink);
        return true;
    }
}