<?php

namespace App\Nova;

use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\ExportAsCsv;

class News extends Articles
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\News::class;

    /**
     * Custom priority level of the resource.
     */
    public static int $priority = 2;

    /**
     * Get the filters available for the resource.
     */
    #[Pure]
    public function filters(NovaRequest $request): array
    {
        return [
            //            new CategoryFilter('news')
//            ExportAsCsv::make()->nameable(),
        ];
    }
}
