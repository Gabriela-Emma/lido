<?php

namespace App\Nova;

use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Http\Requests\NovaRequest;

class News extends Articles
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\News::class;

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static int $priority = 2;

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    #[Pure]
    public function filters(NovaRequest $request): array
    {
        return [
            //            new CategoryFilter('news')
        ];
    }
}
