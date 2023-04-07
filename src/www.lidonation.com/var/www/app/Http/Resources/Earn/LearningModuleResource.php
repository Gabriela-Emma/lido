<?php

namespace App\Http\Resources\Earn;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearningModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $model = strtolower(class_basename($this->model));

        return array_merge(
            [
                'title' => $this->title,
                'content' => $this->content,
                'length' => $this->length,
                'lessons_count' => $this->lessons_count,
                'topics_count' => $this->topics_count,
                $model => $this->model?->toArray(),
            ],
            $this->metadata?->toArray()
        );
    }
}
