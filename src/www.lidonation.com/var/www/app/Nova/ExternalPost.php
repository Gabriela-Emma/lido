<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

class ExternalPost extends Articles
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = \App\Models\ExternalPost::class;

    /**
     * Custom priority level of the resource.
     */
    public static int $priority = 7;

    /**
     * Get the filters available for the resource.
     */
    #[Pure]
    public function filters(NovaRequest $request): array
    {
        return [
            //
        ];
    }
}
