<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoadSnippets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:load-snippets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load snippets from database to a json file that the site can load';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $request = Request::create(route('cache.snippets'), 'GET');
        $response = app()->handle($request);

        Log::info('Snippets loaded.');
    }
}
