<?php

namespace App\Invokables;

use App\Models\Model;
use Illuminate\Support\Str;

class FillPostData
{
    /**
     * fill default values
     * Uses collection of associative array to optimistically fill default value.
     * Associated array for model field, if field is not set, nested array is used.
     * at nested array:
     *  index 0 to specify a different field on model that should be used as the default
     *  index 1 to specify a primitive value to otherwise assign
     *  or a callable that returns a primitive.
     *
     * @param  callable|null  $fieldsCallback a callable that returns an array.
     */
    public function __invoke(Model $model, array $_fields = [], callable $fieldsCallback = null)
    {
        if (is_callable($fieldsCallback)) {
            $fields = collect($fieldsCallback());
        } else {
            $fields = collect(array_merge([
                'meta_title' => ['title', null],
                'slug' => [null, fn ($m, $k) => (Str::slug($m->title))],
                'status' => ['status', 'draft'],
                'user_id' => [null, auth()?->user()?->getAuthIdentifier() ?? 1],
            ], $_fields));
        }

        $fields->each(function ($data, $key) use ($model) {
            if (isset($model->{$key})) {
                return;
            }
            if (isset($model->{$data[0]})) {
                $model->{$key} = $model->{$data[0]};
            } elseif (is_callable($data[1])) {
                $model->{$key} = call_user_func($data[1], $model, $key);
            } else {
                $model->{$key} = $data[1];
            }
        });
    }
}
