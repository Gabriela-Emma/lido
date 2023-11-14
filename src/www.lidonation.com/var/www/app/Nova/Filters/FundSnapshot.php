<?php

namespace App\Nova\Filters;

use App\Models\CatalystExplorer\CatalystSnapshot;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class FundSnapshot extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->whereRelation('catalyst_snapshot.model', 'id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return CatalystSnapshot::get()->mapWithKeys(fn ($c) => [$c->model->label => $c->model_id]);
    }
}
