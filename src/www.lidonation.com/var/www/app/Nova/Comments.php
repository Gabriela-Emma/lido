<?php

namespace App\Nova;

use App\Models\Comment;
use App\Nova\Actions\PublishModel;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Comments extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Comment::class;

    public static $perPageViaRelationship = 25;

    public static $group = 'Meta Data';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $perPageOptions = [25, 50, 100, 250, 500];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'text',
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
            Text::make('title', function (Comment $comment) {
                return $comment->topLevel()->commentable?->commentableName() ?? 'Deleted...';
            })->readonly(),

            MorphTo::make('Commentator')->types([
                User::class,
            ]),

            Markdown::make('Original text'),

            Text::make('', function (Comment $comment) {
                if (! $url = $comment?->commentUrl()) {
                    return '';
                }

                return "<a target=\"show_comment\" href=\"{$url}\">Show</a>";
            })->asHtml(),

            Text::make('status', function (Comment $comment) {
                if ($comment->isApproved()) {
                    return "<div class='inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800'>Approved</div>";
                }

                return "<div class='inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800'>Pending</div>";
            })->asHtml(),

            DateTime::make('Created at'),

            //            Text::make('title', function (Comment $comment) {
            //                return $comment->topLevel()->commentable?->commentableName() ?? 'Deleted...';
            //            })->readonly(),

            //            MorphTo::make(__('Posted To'), 'commentable')->types([
            //                News::class,
            //                Insights::class,
            //                OnboardingContent::class,
            //                Reviews::class,
            //            ]),
            //
            //            MorphTo::make('Commentator')->types([
            //                User::class,
            //                //                CatalystUser::class
            //            ]),
            //
            //            Markdown::make('Original text'),
            //
            //            Text::make('', function (Comment $comment) {
            //                if (! $url = $comment?->commentUrl()) {
            //                    return '';
            //                }
            //
            //                return "<a target=\"show_comment\" href=\"{$url}\">Show</a>";
            //            })->asHtml(),
            //
            //            Text::make('status', function (Comment $comment) {
            //                if ($comment->isApproved()) {
            //                    return "<div class='inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800'>Approved</div>";
            //                }
            //
            //                return "<div class='inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800'>Pending</div>";
            //            })->asHtml(),
            //
            //            DateTime::make('Created at'),
            //
            //            HasMany::make('Metadata', 'metas', Metas::class),
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
                (new PublishModel),
            ]);
    }
}
