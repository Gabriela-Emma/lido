<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Media extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Spatie\MediaLibrary\MediaCollections\Models\Media::class;

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 999991;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        $query->withoutGlobalScopes();

        return parent::indexQuery($request, $query);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'), 'name')->onlyOnForms(),
            Text::make(__('Collection'), 'collection_name')->readonly(),
            Text::make(__('File'), 'file_name')->readonly(),
            Image::make('Image', 'responsive_images')
                ->preview(function ($item) {
                    $mime_type = 'image/png';
                    if (! isset($item['thumbnail'])) {
                        return $item;
                    }

                    return $item['thumbnail']['base64svg'];
                })->thumbnail(function ($item) {
                    if (! isset($item['thumbnail'])) {
                        return $item;
                    }
                    $mime_type = 'image/png';

                    return $item['thumbnail']['base64svg'];
                }),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  Request  $request
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
