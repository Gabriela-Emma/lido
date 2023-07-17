<?php

namespace App\Http\Resources;

use App\Models\Fund;
use App\Models\Proposal;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DraftBallotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $proposals = Proposal::with(['vote',])
            ->whereIn(
                'id',
                 $this->items()->get('model_id')->pluck('model_id')->toArray()
            )->get()->groupBy('fund_id');

        $groups = Fund::whereIn('id', $proposals->keys()->toArray())->get()->map(fn($fund) => ( array_merge(
            (new FundResource($fund))->toArray($request),
            [
                // when assembling group, add the discussion to the group if fund_id match exists
                'rationale' => ($this->rationales
                    ->first(
                        fn($rationale) => $rationale->meta_data->group_id ==  $fund->id
                    ))?->only(['title', 'content', 'status']) ?? [
                        'title' => null,
                        'content' => null,
                        'status' => null,
                    ],
                'items' => (ProposalResource::collection($proposals[$fund->id]))->map(function($resource){
                    return [
                        'model' => $resource->toArray(request())
                    ];
                })
            ]
        )));

        return [
            'hash' => $this->hash,
            'title' => $this->title,
            'content' => $this->content,
            'color' => $this->color,
            'link' => $this->link,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'items_count' => $this->items_count,
            'created_at' => $this->created_at,
            'groups' => $groups,
        ];
    }
}
