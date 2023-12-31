<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MintTxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return array_merge(
            parent::toArray($request),
            [
                'mint' => $this->mint?->toArray(),
            ],
            $this->meta_data->toArray()
        );
    }
}
