<?php

namespace App\Console\Commands;

use App\Jobs\SyncF10ReviewsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;

class SyncF10ReviewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:sync-f10-reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync F10 Reviews';

    public function handle()
    {
        $page = 0;
        do {
            $reviews = Http::get(
                'https://voices.projectcatalyst.io/api/proposal-reviews',
                [
                    'size' => 50,
                    'page' => $page,
                ])->collect()->mapInto(Fluent::class);

            // process reviews
            SyncF10ReviewsJob::dispatch($reviews);

            $page++;

            sleep(5);
        } while ($reviews->isNotEmpty());
    }
}
