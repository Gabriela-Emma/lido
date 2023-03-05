<?php

namespace App\Nova;

use App\Models\Cause;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

//use Spatie\NovaTranslatable\Translatable;

class Causes extends Resource
{
    public static $group = 'Phuffy';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Cause::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'content',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            //            Translatable::make([
            Text::make(__('Title'))->translatable()->sortable(),
            //            ]),
            //            Translatable::make([
            Text::make(__('Meta Title'), 'meta_title')
                ->translatable()
                ->hideFromIndex(),
            //            ]),
            Slug::make(__('Slug'), 'slug')->showOnCreating(),
            Stack::make('Details', [
                Text::make(__('Title'), 'title')->displayUsing(fn ($name) => Str::limit($name, 40)
                ),
                Slug::make(__('Slug'), 'slug')->displayUsing(fn ($name) => Str::limit($name, 35)
                ),
            ]),
            Select::make(__('Status'), 'status')->options([
                'draft' => 'Draft',
                'pending' => 'Pending',
                'voting' => 'Voting',
                'published' => 'Published',
                'funded' => 'Funded',
            ])->sortable(),
            DateTime::make('Published At')
                ->help('Defaults to today when status set to Published. ')
                ->hideWhenUpdating()
                ->sortable(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable()->nullable(),
            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),
            HasMany::make(__('Votes'), 'ratings', Rating::class),
            BelongsToMany::make(__('Links'), 'links')
                ->hideFromIndex()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')
                            ->default(function (NovaRequest $request) {
                                return $request->model()::class;
                            }),
                    ];
                }),
            new Panel('Content', self::contentFields()),
            new Panel('Meta Data', $this->metaDataFields()),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
 public function actions(Request $request): array
 {
     return array_merge([
         static::getGlobalActions(),
     ]);
 }

    public static function contentFields(): array
    {
        return [
            //            Translatable::make([
            Markdown::make(__('Content'), 'content')->translatable(),
            //            ]),
        ];
    }

    public function metaDataFields(): array
    {
        $metaFields = [];
        $modelObj = Cause::find(request()->resourceId);
        if (! isset($modelObj)) {
            return $metaFields;
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title(Str::replace('_', ' ', $meta->key)))
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
                ->hideFromIndex()
                ->exceptOnForms();
        })->concat(collect($metaFields))->all();
    }
}
