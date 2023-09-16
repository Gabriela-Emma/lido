<?php

namespace App\Nova;

use App\Models\Promo;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\ExportAsCsv;

class Promos extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Promo::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Partners';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'))->translatable()->sortable()->rulesFor('en', [
                'required',
            ]),

            BelongsTo::make('Partner', 'user', User::class)->searchable()->hideFromIndex(),
            MorphTo::make('token')->types([
                Nfts::class,
            ])->searchable()->nullable(),

            URL::make(__('URI'), 'uri')->rules(['required'])->hideFromIndex(),
            Select::make(__('Status'), 'status')
                ->sortable()
                ->default('draft')
                ->rules(['required'])
                ->options([
                    'draft' => 'Draft',
                    'scheduled' => 'Scheduled',
                    'published' => 'Published',
                    'retired' => 'Retired',
                ]),
            Select::make(__('Type'), 'type')
                ->sortable()
                ->default('partner')
                ->rules(['required'])
                ->options([
                    'partner' => 'Partner',
                ]),
            Images::make(__('Hero'), 'hero')
                ->conversionOnDetailView('preview')
                ->conversionOnIndexView('thumbnail')
                ->enableExistingMedia(),
            Markdown::make(__('content'))->translatable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
