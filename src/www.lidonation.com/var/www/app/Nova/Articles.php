<?php

namespace App\Nova;

use App\Models\Insight;
use App\Models\Post;
use App\Models\Review;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\AddModelSnippet;
use App\Nova\Actions\ApproveModel;
use App\Nova\Actions\AttachCategory;
use App\Nova\Actions\AttachLink;
use App\Nova\Actions\AttachTag;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\PublishModel;
use App\Nova\Actions\TranslateModel;
use App\Nova\Filters\CategoryFilter;
use App\Nova\Lenses\ContentManager;
use App\Nova\Lenses\NewlyRecordedArticles;
use App\Nova\Metrics\NewArticleRecordings;
use App\Nova\Metrics\PendingCommentsMetric;
use App\Nova\Traits\HasSnippets;
use App\Scopes\LimitScope;
use App\Scopes\PublishedScope;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Articles extends Resource
{
    use HasSnippets;

    public static $group = 'Posts';

    /**
     * Custom priority level of the resource.
     */
    public static int $priority = 1;

    /**
     * The model the resource corresponds to.
     */
    public static string $model = Post::class;

    public static $perPageOptions = [25, 50, 100];

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 7;

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
        'slug',
        'title',
        'content',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes([PublishedScope::class, LimitScope::class]);

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'), 'title')
                ->onlyOnForms()
                ->translatable()
                ->required(),

            Text::make(__('Subtitle'), 'subtitle')
                ->translatable()
                ->withMeta(
                    [
                        'extraAttributes' => [
                            'autocomplete' => 'off',
                        ],
                    ]
                )
                ->onlyOnForms(),

            //            ]),
            Stack::make('Details', [
                Text::make(__('Title'), 'title')->displayUsing(fn ($name) => Str::limit($name, 40)
                ),
                Slug::make(__('Slug'), 'slug')->displayUsing(fn ($name) => Str::limit($name, 35)
                ),
            ]),
            //            Translatable::make([
            Text::make(__('Meta Title'), 'meta_title')
                ->hideFromIndex()
                ->translatable(),
            //            ]),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
                'ready' => 'Ready',
                'scheduled' => 'Scheduled',
            ])->sortable()
                ->required(),
            Select::make(__('Type'), 'type')->options([
                Review::class => 'Reviews',
                \App\Models\News::class => 'News',
                Insight::class => 'Insights',
                \App\Models\OnboardingContent::class => 'OnboardingContent',
                \App\Models\ExternalPost::class => 'ExternalPost',
            ])->onlyOnForms(),
            DateTime::make('Published At')
                ->help('Defaults to today. ')
                ->hideWhenUpdating()
                ->sortable(),
            BelongsTo::make(__('Parent'), 'parent', Articles::class)
                ->sortable()
                ->nullable()
                ->searchable()
                ->hideFromIndex()
                ->default(fn () => 0)
                ->help('Assign a parent if post should treated like a series.
                 This post to show up as next in the series when reading the parent article.'),

            Text::make(__('Article Type'), 'type')->exceptOnForms()
                ->displayUsing(fn ($value) => collect(explode('\\', $value))->last()),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),

            Number::make(__('Order'), 'order')
                ->sortable()
                ->hideFromDetail()
                ->default(fn () => 0),

            new Panel('Media', self::mediaFields()),
            new Panel('Content', self::contentFields()),
            //                        new Panel('Translations', $this->translationsFields()),
            new Panel('Snippets', $this->snippetsFields()),
            HasMany::make('Metadata', 'metas', Metas::class),
            new Panel('Meta Data', $this->metaDataFields()),

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

            HasMany::make(__('Translations'), 'translations', Translations::class)
                ->hideFromIndex(),

            HasMany::make(__('Questions'), 'questions', LegacyQuestions::class)
                ->hideFromIndex(),

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

            MorphMany::make('Comments', 'comments', Comments::class),
        ];
    }

    /**
     * Get the cards available for the request.*
     */
    #[Pure]
    public function cards(NovaRequest $request): array
    {
        return [
            new NewArticleRecordings,
            new PendingCommentsMetric,
        ];
    }

    /**
     * Get the filters available for the resource.
     */
    #[Pure]
    public function filters(NovaRequest $request): array
    {
        return [
            new CategoryFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(NovaRequest $request): array
    {
        return [
            new ContentManager,
            new NewlyRecordedArticles,
        ];
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
                (new PublishModel),
                (new ApproveModel),
                (new AddMetaData),
                (new EditMetaData(Post::class)),
                (new AttachTag),
                (new AttachCategory),
                (new TranslateModel),
                (new AddModelSnippet),
                (new AttachLink),
            ]);
    }

    public static function mediaFields(): array
    {
        return [
            //            Translatable::make([
            Text::make(__('Soundcloud Track ID'), 'content_audio')
                ->hideFromIndex()->translatable(),
            //            ]),
            Images::make(__('Hero'), 'hero')
                ->enableExistingMedia(),
            Files::make(__('Audio'), 'audio')
                ->hideWhenUpdating()
                ->hideFromIndex(),
        ];
    }

    public static function contentFields(): array
    {
        return [
            //            Translatable::make([
            Markdown::make(__('Social Post'), 'social_excerpt')
                ->nullable()
                ->translatable()
                ->help(
                    'This will be use by the bots when posting to to social media.'
                ),
            Markdown::make(__('Comment Prompt'), 'comment_prompt')
                ->nullable()
                ->translatable()
                ->help(
                    'Usually a call to action or a prompting question to solicit a comment.'
                ),
            Markdown::make(__('Excerpt'), 'excerpt')
                ->help(
                    '2 to 3 sentence summary for listing pages on the site.'
                )->nullable()->translatable(),
            Markdown::make(__('Prologue'), 'prologue')
                ->help('blob of text you want to show in a before the article that will only appear on the site.
                 Text put here will show up on social media or in rss feeds.')
                ->nullable()->translatable(),
            Markdown::make(__('Content'), 'content')->translatable()->alwaysShow(),
            Markdown::make(__('Epilogue'), 'epilogue')->nullable()->translatable(),
            //            ]),
        ];
    }

    public function metaDataFields(): array
    {
        $metaFields = [
            Text::make('Editor')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->exceptOnForms()->hideFromIndex(),
            Text::make('Submitted By')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->exceptOnForms()->hideFromIndex(),
            Text::make('Author Email')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->exceptOnForms(),
            Text::make('Link')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->hideFromIndex()->exceptOnForms(),
            Textarea::make('Links')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->hideFromIndex()->exceptOnForms(),
            Textarea::make('Author Comments')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->hideFromIndex()->exceptOnForms(),
            Textarea::make('Notes')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->hideFromIndex()->exceptOnForms(),
            Textarea::make('Idea')
                ->resolveUsing(fn () => $this->meta_data?->content
                )->hideFromIndex()->exceptOnForms(),
        ];
        $modelObj = Post::find(request()->resourceId);
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
