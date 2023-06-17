<?php

namespace App\Services\Observers;

use App\Jobs\CrawlIohkPostsJob;
use DOMDocument;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class IohkBlogCrawlerObserver extends CrawlObserver
{
    protected $postsLinks;

    public function __construct(protected $lang)
    {}

    /**
     * Called when the crawler will crawl the url.
     */
    public function willCrawl(UriInterface $url): void
    {
        Log::info('willCrawl', ['url' => $url]);
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ): void {
        // 1. remove unnecessary info from reponse body
        $cleanedBody = $this->cleanDomDocument($response->getBody());

        // 2. use the cleaned response body to set our crawler object
        $crawler = new Crawler($cleanedBody);

        // 3. extract the class names for all posts header
        $postsHeadClassNamesArr = (array) $this->getPostsHeadClassNames($crawler);

        // 3. extract posts links array from the class names in step 3.
        $postsLinksArray = (array) $this->getPostsLinks($crawler, $postsHeadClassNamesArr);

        //4. concatinate the extracted links array to objects postsLinks property
        $this->postsLinks = $postsLinksArray;
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ): void {
        Log::error('crawlFailed', ['url' => $url, 'error' => $requestException->getMessage()]);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        Log::info('finishedCrawling iohk blog page, will now crawl '.count($this->postsLinks).' articles links');

        // crawl each link, extract post content and save to db.
        try {
            Log::info($this->postsLinks);
            CrawlIohkPostsJob::dispatch($this->postsLinks, $this->lang);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * remove unnecessary info from the response body object
     */
    protected function cleanDomDocument($responseBody)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($responseBody);
        $content = $doc->saveHTML(); //# save HTML
        $content1 = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true)); //# convert encoding
        $content2 = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content1); //# strip all javascript
        $content3 = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $content2); // strip all style
        $html = html_entity_decode($content3);

        return $html;
    }

    /**
     * extract div class names prefixied 'Post__HeadContent'
     */
    protected function getPostsHeadClassNames(Crawler $crawler): array
    {
        $postsHeaderSuffixArray = (array) $crawler->filterXPath('//div[contains(@class, "Post__HeadContent-")]')->evaluate('substring-after(@class, "-")');
        $postsHeaderSuffixSet = [];
        $postsHeaderClassNames = [];

        foreach ($postsHeaderSuffixArray as $key => $val) {
            if (! in_array($val, $postsHeaderSuffixSet)) {
                array_push($postsHeaderSuffixSet, $val);

                $headerClass = 'Post__HeadContent-'.$val;
                array_push($postsHeaderClassNames, $headerClass);
            }
        }

        return (array) $postsHeaderClassNames;
    }

    /**
     * extract posts links within div-with-classes prefixed 'Post__HeadContent'
     */
    protected function getPostsLinks(Crawler $crawler, $postsHeadClasses): array
    {
        foreach ($postsHeadClasses as $key => $class) {
            // $xpathQuery = "//div[contains(@class, '".$class."')]";
            $postsLinksAssArr = $crawler->filterXPath("//div[contains(@class, '".$class."')]")
                ->each(function (Crawler $node, $i) {
                    $postLinkUri = $node->filter('a')->attr('href');
                    $postLinkUrl = 'https://iohk.io'.$postLinkUri;

                    return $postLinkUrl;
                });

            return $postsLinksAssArr;
        }
    }
}
