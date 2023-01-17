<?php

namespace App\Nova;

use App\Models\Proposal;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\AttachCategory;
use App\Nova\Actions\AttachTag;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\SetFund;
use App\Nova\Actions\SetProposalStatus;
use App\Nova\Actions\SyncProposalsDetail;
use App\Nova\Actions\TranslateModel;
use App\Nova\Filters\StatusFilter;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
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

class Proposals extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Proposal::class;

    public static $group = 'Catalyst';

    public static $perPageViaRelationship = 25;

    public static $scoutSearchResults = 50;

    public static $tableStyle = 'tight';

    public static $with = ['fund'];

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
        'id',
        'title',
        'slug',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  Request  $request
     * @return array
     *
     * @throws \Exception
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Stack::make('Details', [
                Text::make(__('Title'), 'title')->displayUsing(fn ($name) => Str::limit($name, 40)
                ),
                Slug::make(__('Slug'), 'slug')->displayUsing(fn ($name) => Str::limit($name, 35)
                ),
            ]),
            Text::make('View Proposal', function () {
                return '<a style="color: #578ae4" href="'.$this->link.'" target="_blank">View</a>';
            })->asHtml()->hideWhenCreating()->hideWhenUpdating(),
            Text::make(__('Title'), 'title')
                ->translatable()
                ->required()
                ->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->onlyOnForms(),
            Slug::make(__('Slug'), 'slug')
                ->showOnCreating()
                ->hideFromIndex()
                ->help('changing slug of already published proposal will break web traffic to proposal.')
                ->displayUsing(fn ($name) => Str::limit($name, 35)),
            Text::make(__('Meta Title'), 'meta_title')
                ->translatable()
                ->hideFromIndex(),

            Text::make(__('Website'), 'website')->hideFromIndex(),
            Text::make(__('Ideascale Link'), 'ideascale_link')->hideFromIndex(),
            //            Currency::make(__('Requested'), 'amount_requested')->sortable(),
            Number::make(__('Requested'), 'amount_requested')->sortable()->required(),

            Select::make(__('Project Status'), 'status')->options([
                'pending' => 'Pending',
                'unfunded' => 'Not Funded',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
                'pivoted' => 'Pivoted',
                'abandoned' => 'Abandoned',
            ])->sortable(),

            Select::make(__('Funding Status'), 'funding_status')->options([
                'pending' => 'Pending',
                'funded' => 'Funded',
                'leftover' => 'Funded w Leftovers',
                'not_approved' => 'Not Approved',
                'over_budget' => 'Over Budget',
                'withdrawn' => 'Withdrawn',
            ])->sortable(),

            Select::make(__('Type'), 'type')->filterable()
                ->options([
                    'proposal' => 'Proposal',
                    'challenge' => 'Challenge',
                ])->required(),

            BelongsTo::make(__('Author'), 'author', CatalystUsers::class)
                ->searchable(),
            BelongsTo::make(__('Fund'), 'fund', Funds::class)
                ->searchable()
                ->filterable(),
            HasMany::make(__('Discussions'), 'discussions', Discussions::class),

            DateTime::make('Funded At')->filterable(),

            HasMany::make('Metadata', 'metas', Metas::class),

            BelongsToMany::make(__('Catalyst Groups'), 'groups', CatalystGroups::class)
                ->hideFromIndex()
                ->searchable(),

            BelongsToMany::make(__('Catalyst Users'), 'users', CatalystUsers::class)
                ->hideFromIndex()
                ->searchable(),

            new Panel('Funding', self::fundingFields()),
            new Panel('Media', self::mediaFields()),
            new Panel('Votes', self::voteFields()),
            new Panel('Content', self::contentFields()),
            new Panel('Meta', $this->metaDataFields()),

            HasMany::make('Comments', 'comments', Rationales::class),
            HasMany::make('Monthly Report', 'monthly_reports', CatalystReports::class),
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
            BelongsToMany::make(__('Tags'), 'tags')
                ->hideFromIndex()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')->default(function (NovaRequest $request) {
                            return $request->model()::class;
                        }),
                    ];
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            (new StatusFilter),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(Proposal::class)),
                (new SetProposalStatus),
                (new SetFund),
                (new AttachTag),
                (new AttachCategory),
                (new TranslateModel),
                (new SyncProposalsDetail),
            ]);
    }

    public static function fundingFields(): array
    {
        return [
            Number::make(__('Received'), 'amount_received')->sortable(),
            //            Currency::make(__('Received'), 'amount_received')->sortable(),
            Select::make(__('Vote Outcome'), 'funding_status')->options([
                'pending' => 'Pending',
                'funded' => 'Funded',
                'leftover' => 'Funded  w Leftovers',
                'not_approved' => 'Not Approved',
                'over_budget' => 'Over Budget',
                'withdrawn' => 'Withdrawn',
            ]),
            Date::make('Funded Updated', 'funding_updated_at')->hideFromIndex(),
        ];
    }

    public static function mediaFields(): array
    {
        return [
            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),
        ];
    }

    public static function voteFields(): array
    {
        return [
            Number::make(__('Yes'), 'yes_votes_count')->sortable(),
            Number::make(__('No'), 'no_votes_count')->sortable(),
        ];
    }

    public function metaDataFields(): array
    {
        $modelObj = Proposal::find(request()->resourceId);
        if (! isset($modelObj)) {
            return [];
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title($meta->key), $meta->key)
                ->resolveUsing(fn () => $meta->content)
                ->onlyOnDetail();
        })->all();

//        return $modelObj->metas?->map(fn ($meta) => Text::make(Str::title($meta->key))
//            ->resolveUsing(fn () => $this->metas?->firstWhere('key', $meta->key)?->content)
//            ->hideFromIndex()
//            ->exceptOnForms()
//        )->all();
    }

    public function contentFields(): array
    {
        return [
            Markdown::make(__('Social Post'), 'social_excerpt')
                ->nullable()
                ->help(
                    'This will be use by the bots when posting to to social media.'
                ),
            Markdown::make(__('Comment Prompt'), 'comment_prompt')
                ->nullable()
                ->help(
                    'Usually a call to action or a prompting question to solicit a comment.'
                ),
            Markdown::make(__('Excerpt'), 'excerpt')
                ->help(
                    '2 to 3 sentence summary for listing pages on the site.'
                )->nullable(),
            Markdown::make(__('Problem'))->translatable()->nullable(),
            Markdown::make(__('Solution'))->translatable()->nullable(),
            Markdown::make(__('Experience'))->translatable()->nullable(),
            Markdown::make(__('Content'), 'content')->translatable()->required(),
            Markdown::make(__('Definition of Success'))->nullable(),
            Text::make('Test', fn () => 'test'),
            Text::make('Shortcode', fn () => ("[proposal id={$this->id}]")),
        ];
    }
}
