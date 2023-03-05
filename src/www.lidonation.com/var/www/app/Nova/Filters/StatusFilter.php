<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Nova\Filters\Filter;

class StatusFilter extends Filter
{
    public function __construct(protected ?string $default = null)
    {
    }

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
     */
    public function apply(Request $request, $query, $value): Builder
    {
        return $query->where('status', $value);
    }

    /**
     * Get the filter's available options.
     */
    #[ArrayShape(['Funded' => 'string', 'Unfunded' => 'string', 'Over Budget' => 'string'])]
    public function options(Request $request): array
    {
        return [
            'Funded' => 'funded',
            'Unfunded' => 'unfunded',
            'Over Budget' => 'over_budget',
        ];
    }

    /**
     * The default value of the filter.
     */
    public function default(): ?string
    {
        return $this->default;
    }
}
