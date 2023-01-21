<?php

namespace App\Services\Observers;

use App\Models\ExternalPost;
use App\Models\Link;
use App\Models\Meta;
use App\Models\Post;
use DOMDocument;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DomCrawler\Crawler;

class IohkPostCrawlerObserver extends CrawlObserver {
    
    protected $title;
    protected $subTitle;
    protected $postedDate;
    protected $content;
    protected $links;

    protected $author;
    protected $authorEmail;

    public function __construct()
    {

    }  
    /**
     * Called when the crawler will crawl the url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     */
    public function willCrawl(UriInterface $url): void
    {
        Log::info('willCrawl',['url'=>$url]);
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ): void
    {
        // 1. remove unnecessary info from reponse body
        $cleanedBody = $this->cleanDomDocument($response->getBody());

        // 2. use the cleaned response body to set our crawler object
        $crawler = new Crawler($cleanedBody);

        // 3. extract the class names for all posts header
        $headerClass =(string) $this->getClassNames($crawler, $prefix='Post__HeadContent', $expectedCount=1);
        $this->title = $this->setTitle($crawler, $headerClass);
        $this->subTitle = $this->setSubTitle($crawler, $headerClass);
        $this->postedDate = $this->setPostedDate($crawler, $headerClass);

        $contentClass = (string) $this->getClassNames($crawler, $prefix='Post__Content', $expectedCount=1);
        $this->content = $this->setContent($crawler, $contentClass);
        $this->links = $this->setLinks($crawler, $contentClass);
        
        $authorContainerClass = (string) $this->getClassNames($crawler, $prefix='Author__Container', $expectedCount=1);
        $this->author = $this->setAuthor($crawler, $authorContainerClass);
        $this->authorEmail = $this->setAuthorEmail($crawler, $authorContainerClass);
        
    }
   

     /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ): void
    {
        Log::error('crawlFailed',['url'=>$url,'error'=>$requestException->getMessage()]);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void 
    {
        Log::info("finishedCrawling");
        
        // save post
        $post = new ExternalPost;
        $post->title = $this->title;
        $post->subtitle = $this->subTitle;
        $post->content = $this->content;
        $post->published_at = $this->postedDate;
        $post->status = 'published';
        // $post->created_at = $this->postedDate;
        try {
            $dbPost = Post::where('slug', '=', Str::slug($this->title, '-'))->first();
            
            if ($dbPost == null) {
                $post->save();
                $this->saveUserMeta($post, $this->author, $this->authorEmail);
            }

        } catch (exception $e) {
            Log::error('Error post not saved');
        }


        //save links
        foreach($this->links as $key=>$linkVal) {
            $link = new Link;
            $link->link = $linkVal;
            
            $link->save();
        }
    }

     // ----------------------------------- CUSTOM METHODS ----------------------------------------------------
    /**
     * remove unnecessary info from the response body object
     */
    protected function cleanDomDocument($responseBody)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($responseBody);
        $content = $doc->saveHTML(); //# save HTML 
        $content1 = mb_convert_encoding($content,'UTF-8',mb_detect_encoding($content,'UTF-8, ISO-8859-1',true)); //# convert encoding
        $content2 = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content1); //# strip all javascript
        $content3 = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $content2); # strip all style
        $html = html_entity_decode($content3);

        return $html;
    }

    /**
     * extract divs-classnames from the provided prefix
     */
    protected function getClassNames(Crawler $crawler, string $prefix, int $expectedCount): string|array
    {
        $postsHeaderSuffixArray =(array) $crawler->filterXPath("//div[contains(@class, '".$prefix."')]")->evaluate('substring-after(@class, "-")');
        
        $postsHeaderSuffixSet = [];
        $postsHeaderClassNames = [];
        
        foreach ($postsHeaderSuffixArray as $key => $val){
            if (! in_array($val, $postsHeaderSuffixSet)) {
                array_push($postsHeaderSuffixSet, $val);
                
                $headerClass = $prefix.'-'.$val;
                array_push($postsHeaderClassNames, $headerClass);
            }
        }
        
        return ($expectedCount==1) ? (string) $postsHeaderClassNames[0] : (array) $postsHeaderClassNames;
    }

    protected function setTitle(Crawler $crawler, string $parentClassName)
    {
            $postTitle = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->filter('a')->filter('h1')->text();
            return $postTitle;
    }

    protected function setSubTitle(Crawler $crawler, string $parentClassName)
    {
            $postSubTitle = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->filter('h3')->text();
            return $postSubTitle;
    }

    protected function setPostedDate(Crawler $crawler, string $parentClassName)
    {
            $postedAt = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->filter('p > span')->text();
            $dateArr = explode(" ", $postedAt);
            $formattedDate = $dateArr[1].'-'.$dateArr[0].'-'.$dateArr[2].' 00:00:00';

            return $formattedDate;
    }

    protected function setContent(Crawler $crawler, string $parentClassName)
    {
        $content = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->html();
        return $content;
    }

    protected function setLinks(Crawler $crawler, string $parentClassName)
    {
        $links = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->filter('a')
                    ->each(function($node, $i) {
                        return $node->attr('href');
                    });
        return $links;
    }

    protected function setAuthor(Crawler $crawler, string $parentClassName)
    {
        $author = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->filter('div > a > h3')->text();
        return $author;
    }

    protected function setAuthorEmail(Crawler $crawler, string $parentClassName)
    {
        $authorEmail = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->filter('div > ul > li > a')->attr('href');
        return $authorEmail;
    }

    protected function saveUserMeta($post, $key, $content)
    {   $meta = new Meta;
        $meta->key = $key;
        $meta->content = $content;
        $meta->model_type = $post->type; 

        $post->metas()->save($meta);

    }

}