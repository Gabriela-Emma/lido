<?php

namespace App\Http\Resources;

use App\Models\CatalystExplorer\Proposal;
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
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'title' => $this->label,
            'fund' => $this->parent ? (new FundResource($this->parent))->toArray($request) : null,
            'proposals_count' => $this->proposals_count > 0 ? $this->proposals_count : $this->parent_proposals_count,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'launch_date' => Carbon::make($this->launched_at)->format('m/d/y'),
            'currency_symbol' => $this->currency_symbol,
            'link' => $this->link,
            'thumbnail_url' => $this->thumbnail_url,
            'gravatar' => $this->gravatar,
            'slug' => $this->slug,
            //@todo parse content using the same parser nova uses
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'label' => $this->label,
            'funded_proposals' => $this->fundedProposals(),

        ];
    }

    public function fundedProposals()
    {
        return Proposal::where('type', 'proposal')
            ->whereNotNull('funded_at')
            ->where('fund_id', $this->id)
            ->count();
    }
}
