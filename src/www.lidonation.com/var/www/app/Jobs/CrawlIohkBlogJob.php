<?php

namespace App\Jobs;

use App\Services\IohkBlogCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrawlIohkBlogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $maxExceptions = 3;

    public $timeout = 60 * 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $baseUrl, protected $relativeUri, protected $lang)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new IohkBlogCrawlerService($this->baseUrl, $this->relativeUri, $this->lang));
    }
}
