<?php

namespace App\Repositories;

use App\Models\Taxonomy;
use App\Scopes\LimitScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Repository implements RepositoryInterface
{
    protected $query;

    // Constructor to bind model to repo
    public function __construct(protected Model $model)
    {
        $this->setModel($model);
    }

    // get the record with the given id
    public function get($idOrSlug, ...$params)
    {
        if (is_int($idOrSlug)) {
            return $this->model->findOrFail($idOrSlug);
        }

        return $this->model->where('slug', '=', $idOrSlug)->first();
    }

    // Get all instances of model
    public function count()
    {
        if ($this->query) {
            return $this->query->count();
        }

        return $this->model->count();
    }

    // Get all instances of model
    public function all(): array|Collection
    {
        if ($this->query) {
            return $this->query->get();
        }

        return $this->model->all();
    }

    public function limit($limit = 12): static
    {
        $this->getModel()::withoutGlobalScopes([LimitScope::class]);
        $this->query = $this->getModel()::query();
        $this->query->limit($limit);

        return $this;
    }

    public function paginate($perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? config('app.limit_scope_limit]');
        $this->getModel()::withoutGlobalScopes([LimitScope::class]);
        $this->query = $this->getModel()::query();

        return $this->getQuery()?->fastPaginate($perPage);
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);

        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // Get the associated model
    public function getModel(): Model
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model): static
    {
        $this->model = $model;
        $this->query = $this->getModel()::query();

        return $this;
    }

    public function setQuery($query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getQuery()
    {
        return $this->query ?? $this->model::query();
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function inTaxonomies(string $taxonomyClass = null, ...$taxonomies): mixed
    {
        $args = func_get_args();
        $taxonomies = collect($args[1])->map(function ($tax) use ($taxonomyClass) {
            if ($tax instanceof Taxonomy) {
                return $tax;
            }

            if (! isset($taxonomyClass)) {
                return null;
            }

            if (strval($tax)) {
                $tax = $taxonomyClass::where('slug', $tax)->first(['id']);
            } else {
                $tax = $taxonomyClass::findOrFail($tax);
            }

            return $tax;
        })->whereNotNull();

        if ($taxonomies->isEmpty()) {
            return $this->query;
        }

        $taxonomies = $taxonomies->groupBy(fn ($tax) => Str::plural(Str::lower(class_basename($tax))));
        $firstGroup = $taxonomies->shift();
        $firstCat = Str::plural(Str::lower(class_basename($firstGroup->first())));
        $this->query->whereHas(
            $firstCat,
            fn ($q) => $q->whereIn("$firstCat.id", $firstGroup?->pluck('id')->all())
        );
        // get the rest
        $taxonomies->each(function ($taxonomies, $key) {
            $this->query->orWhereHas(
                $key,
                function ($q) use ($taxonomies, $key) {
                    $q->whereIn("$key.id", $taxonomies?->pluck('id')->all());
                }
            );
        });

        return $this;
    }
}
