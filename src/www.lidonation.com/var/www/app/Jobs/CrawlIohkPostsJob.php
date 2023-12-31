<?php

namespace App\Jobs;

use App\Services\IohkPostCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrawlIohkPostsJob implements ShouldQueue
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
    public function __construct(protected array $postsLinks, protected $langLocale)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->postsLinks as $key => $link) {
            try {
                (new IohkPostCrawlerService($link, $this->langLocale));
            } catch (e) {
                echo 'error';
            }
        }
    }
}
