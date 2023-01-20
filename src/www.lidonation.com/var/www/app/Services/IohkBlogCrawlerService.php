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

    public function __construct() {}  
    
    /**
     * Crawl the website content.
     * @return true
     */
    public function fetchContent(){
        //# initiate crawler 
        Crawler::create([RequestOptions::ALLOW_REDIRECTS => false, RequestOptions::TIMEOUT => 30])
        ->setParseableMimeTypes(['text/html', 'text/plain'])
        ->setCrawlObserver(new IohkBlogCrawlerObserver())
        ->setMaximumDepth(0)
        ->setDelayBetweenRequests(100)
        ->startCrawling('https://iohk.io/en/blog/posts/page-1/');
            // ->ignoreRobots()
            // ->setMaximumResponseSize(1024 * 1024 * 2) // 2 MB maximum
            // ->setTotalCrawlLimit(0) // limit defines the maximal count of URLs to crawl
            // ->setCrawlProfile(new CrawlInternalUrls('https://www.lipsum.com'))
            // ->acceptNofollowLinks()
            // ->setConcurrency(1) // all urls will be crawled one by one
        return true;
    }
}