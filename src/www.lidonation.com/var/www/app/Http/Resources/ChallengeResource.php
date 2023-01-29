<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => intval($this->id),
            'fundId' => intval($this->parent_id),
            'title' => $this->title,
            'proposalsCount' => $this->proposals_count > 0 ? $this->proposals_count : $this->parent_proposals_count,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
