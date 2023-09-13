<?php

namespace App\Nova\Lenses;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class ContentManager extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public static function query(LensRequest $request, $query)
    {
        $table = $request->model()->getTable();

        return $request->withOrdering($request->withFilters(
            $query->withoutGlobalScopes()
                ->whereIn("$table.status", ['pending', 'draft', 'ready'])
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
        ));

        //        return $request->withOrdering($request->withFilters(
        //            $query->withoutGlobalScopes()
        //                ->select(self::columns($request))
        //                ->join('metas', "$table.id", '=', 'metas.model_id')
        //                ->where("$table.status", '!=', 'published')
        //                ->groupBy("$table.id")
        //            ->orderBy("$table.created_at", 'asc')
        //        ));
    }

    /**
     * Get the columns that should be selected.
     */
    protected static function columns(LensRequest $request): array
    {
        $table = $request->model()->getTable();

        return [
            "$table.title",
            "$table.created_at",
            "$table.type",
            'metas.author_comments',
            'metas.author_email',
            'metas.submitted_by',
            'metas.link',
        ];
    }

    /**
     * Get the fields available to the lens.
     */
    public function fields(Request $request): array
    {
        $novaPath = Nova::path();

        return [
            ID::make('ID', 'id'),
            Text::make('Article', 'title')->displayUsing(function ($name) {
                return Str::limit($name, 28);
            }),
            Text::make('Created At')
                ->displayUsing(fn ($value) => isset($value) ? Carbon::make($value)->format('F d, Y') : null),
            Text::make('Submitted By', fn () => $this->metas?->firstWhere('key', 'submitted_by')?->content
            ),
            Text::make('Author Email', fn () => $this->metas?->firstWhere('key', 'author_email')?->content
            ),
            Text::make('Link', fn () => $this->metsa?->firstWhere('key', 'link')?->content
            )->displayUsing(fn ($name) => Str::limit($name, 28)
            ),
            Text::make('Type', 'type'),

        ];
    }

    /**
     * Get the cards available on the lens.
     */
    #[Pure]
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     */
    public function actions(Request $request): array
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     */
    public function uriKey(): string
    {
        return 'content-manager';
    }
}
