<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalystLedgerSnapshotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'snapshot_id' => $this->snapshot_id,
            'size' => $this->size,
            'epoch' => $this->epoch,
            'fund' => $this->fund()->first()->title,
            'slot' => $this->slot,
            'created_at' => $this->created_at->toDayDateTimeString(),
        ];
    }
}
