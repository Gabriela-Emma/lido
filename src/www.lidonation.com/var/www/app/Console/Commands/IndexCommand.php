<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Laravel\Scout\EngineManager;

class IndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ln:index
            {model : model to index}
            {name? : The name of the index}
            {--k|key= : The name of the primary key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an index';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(EngineManager $manager): void
    {
        collect(['en', 'es', 'fr', 'sw'])
            ->each(
                function ($locale) use ($manager) {
                    app()->setLocale($locale);
                    $this->createIndex($manager);
                }
            );
    }

    public function createIndex(EngineManager $manager): void
    {
        $engine = $manager->engine();
        try {
            $options = [];

            if ($this->option('key')) {
                $options = ['primaryKey' => $this->option('key')];
            }
            $model = $this->argument('model');
            $name = (new $model)->searchableAs();
            $engine->createIndex($name, $options);
            $this->info('Index ["'.$name.'"] created successfully.');

            $client = app(EngineManager::class)->driver('meilisearch');

            $client->index($name)->updatePagination(['maxTotalHits' => 100000]);

            if (method_exists($model, 'getRankingRules')) {
                $rankingRules = $model::getRankingRules();
                if ($rankingRules) {
                    $client->index($name)
                        ->updateRankingRules($rankingRules);
                    $this->info('Ranking Rules ["'.implode(',', $rankingRules).'"] added successfully.');
                }
            }

            if (method_exists($model, 'getFilterableAttributes')) {
                $filters = $model::getFilterableAttributes();
                if ($filters) {
                    $client->index($name)
                        ->updateFilterableAttributes($filters);
                    $this->info('Filters ["'.implode(',', $filters).'"] added successfully.');
                }
            }

            if (method_exists($model, 'getSortableAttributes')) {
                $sortable = $model::getSortableAttributes();
                if ($sortable) {
                    $client->index($name)
                        ->updateSortableAttributes($sortable);
                    $this->info('Sortables ["'.implode(',', $sortable).'"] added successfully.');
                }
            }

            if (method_exists($model, 'getSearchableAttributes')) {
                $searchable = $model::getSearchableAttributes();
                if ($searchable) {
                    $client->index($name)
                        ->updateSearchableAttributes($searchable);
                    $this->info('Searchable ["'.implode(',', $searchable).'"] added successfully.');
                }
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
