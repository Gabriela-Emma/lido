<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'title' => $this->title,
            'proposals_count' => $this->proposals_count > 0 ? $this->proposals_count : $this->parent_proposals_count,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'launch_date'=>Carbon::parse($this->launched_at),
            'currency_symbol'=>$this->currency_symbol
        ];
    }
}
