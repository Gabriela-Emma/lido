<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $model = strtolower(class_basename($this->model));
        return array_merge (
            [
                'hash' => $this->hash,
                'status' => $this->status,
                'quantity' => $this->quantity,
                $model => $this->model?->toArray()
            ],
            $this->metadata?->toArray()
        );
    }
}
