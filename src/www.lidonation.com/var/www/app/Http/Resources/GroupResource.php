<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->username,
            'name' => $this->name,
            'website' => $this->website,
            'proposals_count' => $this->proposals_count,
            'members_count' => $this->members_count,
            'twitter' => $this->twitter,
            'discord' => $this->discord,
            'profile_photo_url' => $this->garavatar ?? $this->thumbnail_url,
            'amount_awarded' => $this->amount_awarded,
            'link' => $this->link,
        ];
    }
}
