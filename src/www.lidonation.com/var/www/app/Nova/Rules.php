<?php

namespace App\Nova;

use App\Models\Question;
use App\Models\Rule;
use App\Nova\Actions\AddMetaData;
use App\Nova\Actions\EditMetaData;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Actions\ExportAsCsv;

class Rules extends Resource
{
    public static $group = 'Quizzes';

    /**
     * The model the resource corresponds to.
     */
    public static string $model = Rule::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'subject',
        'predicate',
        'context',
    ];

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
    ];

    /**
     * Get the value that should be displayed to represent the resource.
     */
    public function title(): string
    {
        return "{$this->subject} {$this->operator} {$this->predicate}";
        //        return (string) data_get($this, static::$title);
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            MorphTo::make(__('Model'), 'model')
                ->types([EveryEpochs::class, Giveaways::class])
                ->searchable(),

            Text::make(__('Subject')),
            Select::make(__('Operator'), 'operator')
                ->options([
                    'lt' => 'Less than',
                    'lte' => 'Less than or equal to',
                    'eq' => 'Equals',
                    'gt' => 'Greater than',
                    'gte' => 'Greater than or equal to',
                ])->default('published')->sortable(),
            Text::make(__('Predicate')),
            Text::make(__('Context')),
            Select::make(__('Apply With'), 'apply_with')
                ->options([
                    'and' => 'AND',
                    'or' => 'OR',
                ])->default('and')->sortable(),
            Select::make(__('Status'), 'status')
                ->options([
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'pending' => 'Pending',
                    'ready' => 'Ready',
                    'scheduled' => 'Scheduled',
                ])->default('published')->sortable(),
            Select::make(__('Type'), 'type')
                ->options([
                    'custom' => 'Custom',
                    'model' => 'Model',
                    'pool' => 'Pool',
                    'epoch' => 'Epoch',
                    'scheduled' => 'Scheduled',
                ])->default('custom')->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    #[Pure]
    public function actions(Request $request): array
    {
        return array_merge(
            static::getGlobalActions(),
            [
                (new AddMetaData),
                (new EditMetaData(Question::class)),
                ExportAsCsv::make()->nameable(),
            ]);
    }
}
