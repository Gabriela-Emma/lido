<?php

namespace App\Nova;

use App\Invokables\GetModels;
use App\Models\Translation;
use App\Nova\Filters\Language;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

class Translations extends Resource
{
    public static $group = 'i18n';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Translation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'key';

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 18;

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
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $models = collect(get_declared_classes())->filter(function ($item) {
            return substr($item, 0, 11) === 'App\Models\\';
        });

        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Group'))->sortable(),
            Text::make(__('Key'))->sortable(),
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable(),

            Select::make(__('Lang'), 'lang')
                ->sortable()
                ->options(
                    collect(config('laravellocalization.supportedLocales'))
                        ->map(fn ($loc) => $loc['name'])),

            Select::make(__('Status'), 'status')->options([
                'published' => 'Published',
                'draft' => 'Draft',
                'pending' => 'Pending',
                'ready' => 'Ready',
                'scheduled' => 'Scheduled',
            ])->sortable(),

            Date::make(__('Created At'))->hideWhenUpdating(),
            Date::make(__('Published At'))->hideWhenUpdating(),

            new Panel('Translation', self::contentFields()),

            new Panel('Source Meta', $this->sourceFields()),
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
    public function filters(Request $request)
    {
        return [
            new Language,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public function contentFields(): array
    {
        return [
            Markdown::make(__('Translation'), 'content'),
        ];
    }

    public function sourceFields(): array
    {
        return [
            Select::make(__('Source Type'), 'source_type')
                ->sortable()
                ->options(
                    (new GetModels)()->combine(
                        (new GetModels)()->toArray()
                    )->toArray()
                ),
            //            BelongsTo::make(__('Source'), 'source', [User::class])
            //                ->searchable(),
            Text::make(__('Source Id'), 'source_id'),
            Text::make(__('Source Field'), 'source_field'),
            Select::make(__('Source Lang'), 'source_lang')
                ->options(
                    collect(config('laravellocalization.supportedLocales'))
                        ->map(fn ($loc) => $loc['name'])),

        ];
    }
}
