<?php

namespace App\Services\Observers;

use App\Models\ExternalPost;
use App\Models\Link;
use App\Models\Meta;
use App\Models\ModelLink;
use App\Models\Post;
use DOMDocument;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class IohkPostCrawlerObserver extends CrawlObserver
{
    protected $title;

    protected $subTitle;

    protected $postedDate;

    protected $content;

    protected $slug;

    protected $links;

    protected $author;

    protected $authorEmail;

    public function __construct(protected $langLocale)
    {
        $this->lang = $langLocale;
    }

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

        //3. assign link property from the page $url
        $this->link = $url;

        //extract postedDate and slug from the url
        [$this->postedDate, $this->slug] = $this->decypherUrl($url);

        // 3. get header class name then scrap the post's title and subtitle.
        $headerClass = (string) $this->getClassNames($crawler, $prefix = 'Post__HeadContent', $expectedCount = 1);
        $this->title = $this->setTitle($crawler, $headerClass);
        $this->subTitle = $this->setSubTitle($crawler, $headerClass);

        // 4. get post content class name then scrap content
        $contentClass = (string) $this->getClassNames($crawler, $prefix = 'Post__Content', $expectedCount = 1);
        $this->content = $this->setContent($crawler, $contentClass);

        // 5. get authoer container class then scrap author name and email.
        $authorContainerClass = (string) $this->getClassNames($crawler, $prefix = 'Author__Container', $expectedCount = 1);
        $this->author = $this->setAuthor($crawler, $authorContainerClass);
        $this->authorEmail = $this->setAuthorEmail($crawler, $authorContainerClass);
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
        Log::info('finishedCrawling');

        // save post
        $locale = $this->lang;
        $post = new ExternalPost;
        $post->title = [$locale => $this->title];
        $post->meta_title = [$locale => $this->subTitle];
        $post->content = [$locale => $this->content];
        $post->slug = $this->slug;
        $post->published_at = $this->postedDate;
        $post->status = 'published';

        try {
            $dbPost = ExternalPost::where('slug', '=', $this->slug)->first() ?? null;

            if ($dbPost != null) {
                ExternalPost::where('slug', $this->slug)->update([
                    'title->'.$locale => $this->title,
                    'meta_title->'.$locale => $this->subTitle,
                    'content->'.$locale => $this->content,
                ]);
            } else {
                $post->save();
                $this->saveUserMeta($post, $this->author, $this->authorEmail);
            }
        } catch (exception $e) {
            Log::error('Error post not saved');
        }

        //save links
        $exPostObj = ExternalPost::where('slug', $this->slug)->first();
        $this->saveLink($exPostObj, $this->link);
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

    protected function decypherUrl($url)
    {
        $urlPath = parse_url($url, PHP_URL_PATH);
        $pathArr = explode('/', $urlPath);
        $dateArr = [$pathArr[4], $pathArr[5], $pathArr[6]]; //[$year, $month, $day]

        // set postedDate and $slug
        $postedDate = implode('-', $dateArr).' 00:00:00';
        $slug = implode('/', $dateArr).'/'.$pathArr[7];

        return [$postedDate, $slug];
    }

    /**
     * extract divs-classnames from the provided prefix
     */
    protected function getClassNames(Crawler $crawler, string $prefix, int $expectedCount): string|array
    {
        $postsHeaderSuffixArray = (array) $crawler->filterXPath("//div[contains(@class, '".$prefix."')]")->evaluate('substring-after(@class, "-")');

        $postsHeaderSuffixSet = [];
        $postsHeaderClassNames = [];

        foreach ($postsHeaderSuffixArray as $key => $val) {
            if (! in_array($val, $postsHeaderSuffixSet)) {
                array_push($postsHeaderSuffixSet, $val);

                $headerClass = $prefix.'-'.$val;
                array_push($postsHeaderClassNames, $headerClass);
            }
        }

        return ($expectedCount == 1) ? (string) $postsHeaderClassNames[0] : (array) $postsHeaderClassNames;
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

    protected function setContent(Crawler $crawler, string $parentClassName)
    {
        $content = $crawler->filterXPath("//div[contains(@class, '".$parentClassName."')]")->html();

        return $content;
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
    {
        $meta = new Meta;
        $meta->key = $key;
        $meta->content = $content;
        $meta->model_type = $post->type;

        $post->metas()->save($meta);
    }

    protected function saveLink($modelObj, $link)
    {
        try {
            $duplicateLink = Link::where('link', $link)->where('type', $modelObj->type)->first() ?? null;
            //if no duplicate link exists save it with its relation to linkable obj.

            if ($duplicateLink == null) {
                echo '$duplicateLink';
                $newLink = new Link;
                $newLink->link = $link;
                $newLink->type = $modelObj->type;
                $newLink->save();

                $this->saveModelLink($modelObj, $newLink->id);
            } else {
                echo 'link is this';
                $this->saveModelLink($modelObj, $duplicateLink->id);
            }
        } catch (exception $e) {
        }
    }

    protected function saveModelLink($modelObj, $linkId)
    {
        $duplicateModelLink = ModelLink::where('link_id', $linkId)
            ->where('model_id', $modelObj->id)
            ->where('model_type', $modelObj->type)
            ->first() ?? null;

        if ($duplicateModelLink == null) {
            $rel = new ModelLink;
            $rel->link_id = $linkId;
            $rel->model_id = $modelObj->id;
            $rel->model_type = $modelObj->type;
            $rel->save();
            echo 'saved';
        } else {
            echo 'not saved';
        }
    }
}
