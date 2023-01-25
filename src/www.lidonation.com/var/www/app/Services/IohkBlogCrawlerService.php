<?php

namespace App\Services;

use App\Services\Observers\IohkBlogCrawlerObserver;
use Illuminate\Http\Request;
use App\Observers\CustomCrawlerObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\Crawler;
use GuzzleHttp\RequestOptions;

class IohkBlogCrawlerService
{

    // public function __invoke()
    // {
    //     echo App::currentLocale() . "is the current locale.";   
    //     $this->fetchContent();
    // }

    public function __construct(protected $baseUrl, protected $uri, protected $langLocale) {
        $this->baseUrl = $baseUrl;
        $this->uri =  $uri;
        $this->langLocale = $langLocale;

        $this->fetchContent();
    }  
    
    /**
     * Crawl the website content.
     * @return true
     */
    public function fetchContent()
    {   
        $fullUrl = $this->baseUrl."/".$this->uri;

        //# initiate crawler 
        Crawler::create([RequestOptions::ALLOW_REDIRECTS => false, RequestOptions::TIMEOUT => 30])
        ->setCrawlProfile(new CrawlInternalUrls($this->baseUrl))
        ->setParseableMimeTypes(['text/html', 'text/plain'])
        ->setCrawlObserver(new IohkBlogCrawlerObserver($this->langLocale))
        ->setMaximumDepth(0)
        ->setDelayBetweenRequests(100)
        ->startCrawling($fullUrl);
            // ->ignoreRobots()
            // ->setMaximumResponseSize(1024 * 1024 * 2) // 2 MB maximum
            // ->setTotalCrawlLimit(0) // limit defines the maximal count of URLs to crawl
            // ->setCrawlProfile(new CrawlInternalUrls('https://www.lipsum.com'))
            // ->acceptNofollowLinks()
            // ->setConcurrency(1) // all urls will be crawled one by one
        return true;
    }
}