<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class FundResource extends JsonResource
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
            'title' => $this->label,
            'fund' => $this->parent ? (new FundResource($this->parent))->toArray($request) : null,
            'proposals_count' => $this->proposals_count > 0 ? $this->proposals_count : $this->parent_proposals_count,
            'amount' => humanNumber($this->amount),
            'currency' => $this->currency,
            'launch_date' => Carbon::make($this->launched_at)->format('m/d/y'),
            'currency_symbol' => $this->currency_symbol,
            'link' => $this->link,
            'thumbnail_url' => $this->thumbnail_url,
            'gravatar' => $this->gravatar,

        ];
    }
}
