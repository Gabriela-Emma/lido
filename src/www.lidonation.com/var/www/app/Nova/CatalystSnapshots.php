<?php

namespace App\Nova;

use App\Models\CatalystSnapshot;
// use App\Models\CatalystVotingPower;
use App\Models\Fund;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\AttachCategory;
use App\Nova\Actions\AttachLink;
use App\Nova\Actions\AttachTag;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\ImportVotingPower;
use App\Nova\Actions\PublishModel;
use App\Nova\Actions\SyncSnapshotVotingPowers;
use App\Scopes\PublishedScope;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class CatalystSnapshots extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CatalystSnapshot::class;

    public static $group = 'Catalyst';

    public static $perPageViaRelationship = 25;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $perPageOptions = [25, 50, 100, 250];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'content',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('Epoch'))->sortable(),

            Number::make('Order')
                ->required(),

            DateTime::make('Snapshot At')
                ->sortable(),

            MorphTo::make(__('Type'), 'model')
            ->types([
                Funds::class
            ])->searchable()
            ->filterable(),

            HasMany::make('Metadata', 'metas', Metas::class),

            HasMany::make('Voting Powers', 'votingPowers', CatalystVotingPowers::class)
                ->hideFromIndex(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return array_merge(
            [
                (new ImportVotingPower)->onlyOnDetail(),
                (new AddMetaData),
                (new EditMetaData(Fund::class)),
                (new PublishModel),
                (new AttachTag),
                (new AttachCategory),
                (new AttachLink),
            ],
            static::getGlobalActions(),
        );
    }

    public function metaDataFields(): array
    {
        $modelObj = Fund::find(request()->resourceId);
        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas->map(
            fn ($meta) => Text::make(Str::title($meta->key))
                ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
                ->hideFromIndex()
                ->exceptOnForms()
        )->all();
    }

    public static function mediaFields(): array
    {
        return [
            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),
        ];
    }

    public static function contentFields(): array
    {
        return [
            Markdown::make(__('Excerpt'), 'excerpt')->sortable(),
            //            Markdown::make(__('Comment Prompt'), 'comment_prompt')
            //                ->nullable()
            //                ->help(
            //                    'Usually a call to action or a prompting question to solicit a comment.'
            //                ),
            Markdown::make(__('Content'), 'content')->sortable(),
        ];
    }
}
