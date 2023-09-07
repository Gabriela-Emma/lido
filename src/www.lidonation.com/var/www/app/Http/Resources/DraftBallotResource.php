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
        $items = $this->items()->get(['model_id', 'id'])->map(
            fn($i) => ([ 'id' => $i->id, 'model_id' => $i->model_id ])
        );
        $items = ($items->pluck('model_id'))->combine($items->values());

        $proposals = Proposal::with(['vote',])
            ->whereIn(
                'id',
                $items->keys()->toArray()
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
                'items' => (ProposalResource::collection($proposals[$fund->id]))
                ->map(function($resource) use ($items)  {
                    return [
                        'id' => $items[$resource?->id]['id'],
                        'model' => $resource->toArray(request())
                    ];
                })
            ]
        )));

        return [
            'user_id' => $this->user_id,
            'hash' => $this->hash,
            'title' => $this->title,
            'content' => $this->content,
            'color' => $this->color,
            'link' => $this->link,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'items_count' => $this->items_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'groups' => $groups,
        ];
    }
}
