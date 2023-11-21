<?php

namespace App\Console\Commands;

use App\Invokables\GetModels;
use App\Jobs\SyncTranslationJob;
use App\Models\Insight;
use App\Models\Post;
use App\Models\Review;
use App\Scopes\LimitScope;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SyncTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'ln:sync-translations
    //         {model : model type to translate}
    //         {source=en : original source lang}
    //         {targets?* : languages to translate to}
    //         {fields?* : space delineated fields on model to translate}
    //         {--pre-populate}
    //         {--publish}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ln:sync-translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Models translations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $fields = collect(
            $this->argument('fields') ? explode(',', $this->argument('fields')) : []
        );
        $source = $this->argument('source') ?? 'en';
        if ($this->argument('targets')) {
            $targets = collect(explode(',', $this->argument('targets')));
        } else {
            $targets = collect(config('laravellocalization.supportedLocales'))->keys();
        }

        if ($this->argument('model') !== null) {
            $models = collect([$this->argument('model')]);
        } else {
            $models = (new GetModels)();
        }

        $models->each(function ($modelClass) use ($fields, $source, $targets) {
            switch ($modelClass) {
                case Post::class:
                case Insight::class:
                case Review::class:
                    $modelClass::withoutGlobalScope(LimitScope::class);
                    break;
            }
            $modelClass->cursor()
                // get models
                ->each(function ($model) use ($fields, $source, $targets) {
                    // get supported target languages
                    $targets->each(function ($target) use ($model, $fields, $source) {
                        // get fields on model to translate
                        collect(! empty($fields) ? $fields : $model->translatable)
                            ->each(function ($field) use ($model, $target, $source) {
                                if ($target !== $source) {
                                    if (! in_array($field, $model->translatableExcludedFromGeneration)) {
                                        SyncTranslationJob::dispatch(
                                            $model,
                                            $field,
                                            $source,
                                            $target,
                                            $this->option('publish'),
                                            $this->option('pre-populate')
                                        );
                                    }
                                }
                            });
                    });
                });
        });
    }

    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'model type to translate', null],
            ['source', InputArgument::OPTIONAL, 'original source lang', 'en'],
            ['fields', InputArgument::OPTIONAL, 'space delineated fields on model to translate', null],
            ['targets', InputArgument::OPTIONAL, 'languages to translate to', null],
        ];
    }

    protected function getOptions()
    {
        return [
            ['pre-populate', null, InputOption::VALUE_OPTIONAL, 'should we generate', false],
            ['publish', null,  InputOption::VALUE_OPTIONAL, 'original source lang', false],
        ];
    }
}
