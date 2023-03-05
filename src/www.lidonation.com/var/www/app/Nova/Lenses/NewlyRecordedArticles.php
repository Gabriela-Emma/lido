<?php

namespace App\Nova\Lenses;

use App\Nova\Metrics\NewArticleRecordings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Nova;

class NewlyRecordedArticles extends Lens
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
                ->select(self::columns($request))
                ->join('media', "$table.id", '=', 'media.model_id')
                ->where('media.created_at', '>=', Carbon::today()->subDays(14))
                ->where('media.collection_name', 'audio')
//            ->orderBy('media.id', 'asc')
        ));
    }

    /**
     * Get the columns that should be selected.
     */
    protected static function columns(LensRequest $request): array
    {
        $table = $request->model()->getTable();

        return [
            DB::raw("DISTINCT ON (posts.id) $table.id"),
            "$table.title",
            'media.created_at',
            "$table.created_at",
            "$table.type",
            'media.id as media_id',
            //            DB::raw('COUNT(posts.id) as occurrences'),
            //            DB::raw('sum(licenses.price) as revenue'),
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
            Text::make('Article', 'title'),
            Text::make('Type', 'type'),
            DateTime::make('Recorded At', 'created_at')->format('l h:s A'),
            Text::make('Media', 'media_id')
                ->displayUsing(fn ($name) => "<a href='$novaPath/resources/media/$name'>$name</a>")
                ->asHtml(),

        ];
    }

    /**
     * Get the cards available on the lens.
     */
    #[Pure]
 public function cards(Request $request): array
 {
     return [
         new NewArticleRecordings,
     ];
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
        return 'newly-recorded-articles';
    }
}
