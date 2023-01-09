<?php

namespace App\Nova\Traits;

use App\Nova\Snippets;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

trait HasSnippets
{
    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function snippetsFields(): array
    {
        return [
            BelongsToMany::make(__('Snippets'), 'snippets', Snippets::class)
                ->onlyOnDetail()
                ->searchable()->fields(function () {
                    return [
                        Text::make(__('Model'), 'model_type')->default(function (NovaRequest $request) {
                            return $request->model()::class;
                        }),
                    ];
                }),
        ];
    }
}
