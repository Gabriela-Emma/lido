<?php

namespace App\Nova;

use App\Models\Fund;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\AttachCategory;
use App\Nova\Actions\AttachLink;
use App\Nova\Actions\AttachTag;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\PublishModel;
use App\Scopes\PublishedScope;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Funds extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Fund::class;

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
            Text::make(__('Title'))
            ->sortable()
            ->required(),
            Text::make(__('Slug'))->sortable(),

            Text::make(__('Type'))->sortable(),
            //            Text::make(__('Manager')),
            Text::make(__('Meta Title'), 'meta_title')
                ->hideFromIndex(),

            Text::make(__('Label'), 'label')
                ->resolveUsing(fn () => $this->getRawOriginal('label')),

            Stack::make('Details', [
                Text::make(__('Title'), 'title'),
                Slug::make(__('Summary'), 'summary'),
            ])->readonly(),
            Select::make(__('Status'), 'status')->options([
                'draft' => 'Draft',
                'pending' => 'Pending',
                'submit' => 'Submit',
                'refine' => 'Finalize',
                'assess' => 'Assess',
                'qa' => 'Assess QA',
                'governance' => 'Governance',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
            ])->default(fn () => 'pending')->sortable(),
            Select::make(__('Currency'), 'currency')->options([
                'usd' => 'USD',
                'ada' => 'ADA',
            ])->default(fn () => 'ada')->sortable(),

            DateTime::make('Launched At')
                ->sortable(),

            Number::make('Amount')
            ->required(),

            // DateTime::make('Awarded At')
            //     ->sortable()
            //     ->displayUsing(fn ($value) => (!!$value ? Carbon::make($value)?->format('F d, Y') : '') ),

            //            Currency::make(__('Amount'), 'amount')
            //                ->currency('USD')
            //                ->min(1)
            //                ->sortable(),
            HasMany::make('Metadata', 'metas', Metas::class),

            BelongsTo::make(__('Parent'), 'parent', Funds::class)
                ->sortable()
                ->nullable()
                ->searchable()
                ->hideFromIndex(),
            Color::make(__('Color'))->nullable(),
            new Panel('Media', self::mediaFields()),
            new Panel('Content', self::contentFields()),
            new Panel('Meta', $this->metaDataFields()),
            BelongsToMany::make(__('Categories'), 'categories')
                ->hideFromIndex()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')
                            ->default(function (NovaRequest $request) {
                                return $request->model()::class;
                            }),
                    ];
                }),
            HasMany::make('Comments', 'comments', Rationales::class),
            HasMany::make('Fund Challenges', 'fundChallenges', Funds::class),
            HasMany::make('Sibling Challenges', 'siblingFundChallenges', Funds::class),
            HasMany::make('Proposals', 'proposals', Proposals::class),

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
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(Fund::class)),
                (new PublishModel),
                (new AttachTag),
                (new AttachCategory),
                (new AttachLink),
            ]
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
