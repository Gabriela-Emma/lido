<?php

namespace App\Nova;

use App\Nova\Actions\fetchIohkBlog;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\ExportAsCsv;

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

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
    public function actions(NovaRequest $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new fetchIohkBlog),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
