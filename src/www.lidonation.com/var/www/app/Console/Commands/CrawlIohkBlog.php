<?php

namespace App\Console\Commands;

use App\Jobs\CrawlIohkBlogJob;
use Illuminate\Console\Command;

class CrawlIohkBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:crawl-iohk-blog
                            {--base-url=} : The base url to crawl
                            {--uri=} : The relative url to crawl
                            {--lang=} : Set the language to crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl iohk blog site and save as posts to external post table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $baseUrl = trim($this->option('base-url') ?? 'https://iohk.io', '/');
        $uri = trim($this->option('uri') ?? '/blog/posts/page-1', '/');
        $langLocale = $this->option('lang') ?? 'en';
        $uriPrefix = ($this->option('lang') == 'ja') ? 'jp' : $langLocale;

        $relativeUri = "/{$uriPrefix}/{$uri}";

        CrawlIohkBlogJob::dispatch($baseUrl, $relativeUri, $langLocale); //initiate the crawler
    }
}
