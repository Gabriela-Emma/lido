<?php

namespace App\Nova;

use App\Models\Insight;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class Insights extends Articles
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = Insight::class;

    /**
     * Custom priority level of the resource.
     */
    public static int $priority = 3;

    /**
     * Get the filters available for the resource.
     */
    #[Pure]
    public function filters(Request $request): array
    {
        return [
            //            new CategoryFilter('news')
        ];
    }
}
