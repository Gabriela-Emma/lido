<?php

namespace App\Nova;

use App\Models\Snippet;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\TranslateModel;
use App\Scopes\PublishedScope;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

//use Spatie\NovaTranslatable\Translatable;

class Snippets extends Resource
{
    // use HasTranslations;

    public static $group = 'i18n';

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 12;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Snippet::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'content',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name')),

            Text::make(__('Context')),
            Text::make(__('type'))->default(fn () => Snippet::class),
            URL::make(__('Preview Url'), 'preview_url')->displayUsing(fn ($url) => $url ?: '-'),
            Number::make(__('Order')),
            Select::make(__('Status'), 'status')
                ->options([
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'ready' => 'Ready',
                    'scheduled' => 'Scheduled',
                ])->sortable()
                ->displayUsingLabels()
                ->rules(['required'])
                ->default('draft'),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable()->nullable(),
            //
            new Panel('Media', self::mediaFields()),
            new Panel('Content', self::contentFields()),
            new Panel('Meta Data', $this->metaDataFields()),
        ];
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
    #[Pure]
    public function actions(NovaRequest $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new TranslateModel),
                (new AddMetaData),
                (new EditMetaData(\App\Models\Snippet::class)),
                ExportAsCsv::make()->nameable(),

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
        $modelObj = Snippet::find(request()->resourceId);
        if (! $modelObj) {
            return [];
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title(Str::replace('_', ' ', $meta->key)))
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
                ->hideFromIndex()
                ->exceptOnForms();
        })->all();
    }

    public static function mediaFields(): array
    {
        return [
            //            Medialibrary::make(__('Hero'), 'hero'),
            //            Text::make(__('Soundcloud Track ID'), 'content_audio')
            //                ->hideFromIndex(),
            Images::make(__('Hero'), 'hero'),
            //            Files::make(__('Audio'), 'audio')
            //                ->hideWhenUpdating()
            //                ->hideFromIndex(),
        ];
    }
}
