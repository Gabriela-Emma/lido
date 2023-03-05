<?php

namespace App\Nova\Filters;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Nova\Filters\Filter;

class CategoryFilter extends Filter
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
        $cat = Category::where('slug', $value)->first(['id']);

        return $query->whereHas('categories', fn ($query) => $query->where('categories.id', $cat?->id));
    }

    /**
     * Get the filter's available options.
     */
    #[ArrayShape(['News' => 'string', 'Onboarding' => 'string'])]
    public function options(Request $request): array
    {
        return [
            'News' => 'news',
            'Onboarding' => 'noobs',
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
