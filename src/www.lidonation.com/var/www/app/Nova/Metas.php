<?php

namespace App\Nova;

use App\Models\Meta;
use App\Nova\CatalystExplorer\Funds;
use App\Nova\CatalystExplorer\Groups;
use App\Nova\CatalystExplorer\Proposals;
use App\Nova\CatalystExplorer\Users;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Metas extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Meta::class;

    public static $perPageOptions = [50, 100, 250, 400];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public function title(): string
    {
        return "{$this->key}:{$this->content}";
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return $this->metaDataFields();
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return [
            ExportAsCsv::make()->nameable(),
        ];
    }

    public function metaDataFields(): array
    {

        $metaFields = [
            ID::make('ID', 'id')->sortable(),
            Text::make(__('Key'), 'key')->sortable()->filterable(),
            Markdown::make(__('Content'), 'content')
                ->alwaysShow()
                ->filterable()
                ->hideFromIndex(),
            Text::make(__('Value'), 'content')
                ->onlyOnIndex()
                ->filterable()
                ->sortable(),
            MorphTo::make(__('Type'), 'model')->types([
                Articles::class,
                AnswerResponses::class,
                Comments::class,
                Category::class,
                EveryEpochs::class,
                Discussions::class,
                Funds::class,
                Giveaways::class,
                LearningLessons::class,
                LearningModules::class,
                LearningTopics::class,
                Nfts::class,
                Podcasts::class,
                Proposals::class,
                Rating::class,
                Rewards::class,
                Users::class,
                Groups::class,
            ])->searchable()
                ->filterable(),
        ];

        $modelObj = Meta::find(request()->resourceId);

        if (! isset($modelObj)) {
            return $metaFields;
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title($key->key), $key->key)
                ->resolveUsing(fn () => $meta->content);
        })->concat(collect($metaFields))->all();
    }
}
