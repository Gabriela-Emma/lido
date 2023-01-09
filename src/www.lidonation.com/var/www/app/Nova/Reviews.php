<?php

namespace App\Nova;

use App\Models\Review;
use App\Nova\Actions\GenerateModelRatingImages;
use Illuminate\Http\Request;
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
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Reviews extends Articles
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Review::class;

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static int $priority = 4;

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    #[Pure]
    public function filters(Request $request): array
    {
        return [
            //            new CategoryFilter('news')
        ];
    }

       /**
        * Get the actions available for the resource.
        *
        * @param  Request  $request
        * @return array
        */
       #[Pure]
    public function actions(Request $request): array
    {
        return array_merge(
            parent::actions($request),
            [
                (new GenerateModelRatingImages),
            ]
        );
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'), 'title')->onlyOnForms(),
            Stack::make('Details', [
                Text::make(__('Title'), 'title')->displayUsing(fn ($name) => Str::limit($name, 40)
                ),
                Slug::make(__('Slug'), 'slug')->displayUsing(fn ($name) => Str::limit($name, 35)
                ),
            ]),
            Text::make(__('Meta Title'), 'meta_title')
                ->hideFromIndex(),
            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
                'ready' => 'Ready',
                'scheduled' => 'Scheduled',
            ])->sortable(),
            DateTime::make('Published At')
                ->help('Defaults to today. ')
                ->hideWhenUpdating(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),

            Number::make(__('Order'), 'order')
                ->sortable()
                ->hideFromDetail()
                ->default(fn () => 0),

            new Panel('Media', self::mediaFields()),
            new Panel('Content', self::contentFields()),
            HasMany::make(__('Discussions'), 'discussions', Discussions::class),
            new Panel('Snippets', $this->snippetsFields()),
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

//       /**
//        * Get the fields displayed by the resource.
//        *
//        * @param  Request  $request
//        * @return array
//        */
//       public function fields(Request $request): array
//       {
//           return [
//               ID::make(__('ID'), 'id')->sortable(),
//               Text::make(__('Title'), 'title')->onlyOnForms(),
//               Stack::make('Details', [
//                   Text::make(__('Title'), 'title')->displayUsing(fn ($name) => Str::limit($name, 40)
//                   ),
//                   Slug::make(__('Slug'), 'slug')->displayUsing(fn ($name) => Str::limit($name, 35)
//                   ),
//               ]),
//               Text::make(__('Meta Title'), 'meta_title')
//                   ->hideFromIndex(),
//               Select::make(__('Status'), 'status')->options([
//                   'published' => 'Published',
//                   'draft' => 'Draft',
//                   'pending' => 'Pending',
//                   'ready' => 'Ready',
//                   'scheduled' => 'Scheduled',
//               ])->sortable(),
//               DateTime::make('Published At')
//                   ->help('Defaults to today. ')
//                   ->hideWhenUpdating(),
//               BelongsTo::make(__('Author'), 'author', User::class)
//                   ->searchable(),
//
//               Number::make(__('Order'), 'order')
//                   ->sortable()
//                   ->hideFromDetail()
//                   ->default(fn () => 0),
//
//               new Panel('Media', self::mediaFields()),
//               new Panel('Content', self::contentFields()),
//               HasMany::make(__('Discussions'), 'discussions', Discussions::class),
//               new Panel('Snippets', $this->snippetsFields()),
//               new Panel('Meta Data', $this->metaDataFields()),
//
//               BelongsToMany::make(__('Links'), 'links')
//                   ->hideFromIndex()
//                   ->searchable()->fields(function () {
//                       return [
//                           Text::make(__('Model'), 'model_type')
//                               ->default(function (NovaRequest $request) {
//                                   return $request->model()::class;
//                               }),
//                       ];
//                   }),
//               BelongsToMany::make(__('Categories'), 'categories')
//                   ->hideFromIndex()
//                   ->searchable()->fields(function () {
//                       return [
//                           Text::make(__('Model'), 'model_type')
//                               ->default(function (NovaRequest $request) {
//                                   return $request->model()::class;
//                               }),
//                       ];
//                   }),
//               BelongsToMany::make(__('Tags'), 'tags')
//                   ->hideFromIndex()
//                   ->searchable()->fields(function () {
//                       return [
//                           Text::make(__('Model'), 'model_type')->default(function (NovaRequest $request) {
//                               return $request->model()::class;
//                           }),
//                       ];
//                   }),
//
//           ];
//       }

       public static function contentFields(): array
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
               Markdown::make(__('Summary'), 'excerpt')
                   ->help(
                       '2 to 3 sentence summary for listing pages on the site.'
                   )->nullable(),
               Markdown::make(__('Transparency Disclaimer'), 'prologue')
                   ->help('Blob about notable circumstance about the making of the review. credits. Transparency.')
                   ->nullable(),
               Markdown::make(__('Content'), 'content'),
               //            Markdown::make(__('Epilogue'), 'epilogue')->nullable(),
           ];
       }
}
