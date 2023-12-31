<?php

namespace App\Nova\CatalystExplorer;

use App\Models\CatalystExplorer\CatalystUser;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use App\Nova\Actions\ValidateClaims;
use App\Nova\Lenses\PendingClaims;
use App\Nova\Resource;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Votes extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = Votes::class;

    public static $group = 'Catalyst';

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
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('Author'), 'author', CatalystUsers::class)
                ->searchable(),

            MorphTo::make('model')->types([
                Proposals::class,
            ])->searchable()->nullable(),

            Boolean::make(__('Vote')),

            Markdown::make(__('content'))->translatable(),
        ];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
    public function actions(Request $request): array
    {
        return [
            (new AddMetaData),
            (new EditMetaData(CatalystUser::class)),
            (new ValidateClaims),
            ExportAsCsv::make()->nameable(),
        ];
    }

    public function lenses(NovaRequest $request)
    {
        return [
            (new PendingClaims),
        ];
    }
}
