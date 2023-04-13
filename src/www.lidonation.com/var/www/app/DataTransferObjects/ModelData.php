<?php

namespace App\DataTransferObjects;

use App\Models\Model;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ModelData extends Data
{
    public function __construct(
        public ?int $id,

        public ?string $slug,

        public ?string $title,

        public ?string $content,

        public ?string $type,

        #[TypeScriptOptional]
        public ?string $link
    ) {}

    public static function fromModel(Model $model)
    {
        return new self(
            id: $model->id,
            slug: null,
            title: $model->title,
            content: $model->content ?? $model->label,
            type: class_basename($model::class),
            link: $model->link,
        );
    }
}
