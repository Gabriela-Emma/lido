<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

class ExternalPost extends Articles
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\ExternalPost::class;

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static int $priority = 7;

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
            //
        ];
    }
}
