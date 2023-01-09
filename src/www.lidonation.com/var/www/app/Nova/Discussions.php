<?php

namespace App\Nova;

use App\Models\Discussion;
use App\Models\Post;
use App\Nova\Traits\HasSnippets;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

class Discussions extends Resource
{
    use HasSnippets;

    public static $group = 'Meta Data';

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
        'content',
    ];

    public static $perPageOptions = [25, 50, 100, 250, 500];

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 6;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = Discussion::class;

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 3;

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    #[Pure]
    public function filters(Request $request): array
    {
        return [];
    }

    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'), 'title'),
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
            BelongsTo::make(__('Review'), 'review', Reviews::class)
                ->searchable(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),
            HasMany::make(__('Ratings'), 'ratings'),
            HasMany::make(__('Rationales'), 'comments', Rationales::class),
            Number::make(__('Order'), 'order')
                ->sortable()
                ->hideFromDetail()
                ->default(fn () => 0),
            Markdown::make(__('Comment Prompt'), 'comment_prompt'),
            Markdown::make(__('Content'), 'content'),
            //            new Panel('Translations', $this->translationsFields()),
            new Panel('Snippets', $this->snippetsFields()),
            new Panel('Meta Data', $this->metaDataFields()),
        ];
    }

    public function metaDataFields(): array
    {
        $metaFields = [
            Text::make('Submitted By')
                ->resolveUsing(fn () => $this->meta_data?->submitted_by
                )->exceptOnForms()->hideFromIndex(),
            Text::make('Author Email')
                ->resolveUsing(fn () => $this->meta_data?->author_email
                )->exceptOnForms(),
        ];
        $modelObj = Post::find(request()->resourceId);
        if (! isset($modelObj)) {
            return $metaFields;
        }

        return $modelObj->metas->map(function ($meta) {
            return Text::make(Str::title(Str::replace('_', ' ', $meta->key)))
                ->resolveUsing(fn () => $this->meta_data?->{$meta->key})
                ->hideFromIndex()
                ->exceptOnForms();
        })->concat(collect($metaFields))->all();
    }
}
