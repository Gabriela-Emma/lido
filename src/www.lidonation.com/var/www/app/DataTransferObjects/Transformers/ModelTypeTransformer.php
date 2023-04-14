<?php

namespace App\DataTransferObjects\Transformers;

use App\Models\Model;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class ModelTypeTransformer implements Transformer
{
    public function __construct(
        protected Model $model
    ){}

    public function transform(DataProperty $property, mixed $value): string
    {
        return class_basename($this->model::class);
    }
}
