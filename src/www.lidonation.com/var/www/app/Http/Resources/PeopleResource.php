<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PeopleResource extends JsonResource
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
            'username' => $this->username,
            'name' => $this->name,
            'website' => $this->website,
            'link' => $this->link,
            'ideascale_link' => $this->ideascale_link,
            'ideascale_user' => Str::remove(' ', $this->author?->username),
            'ideascale_id' => (int) $this->meta_data?->ideascale_id,
            'average_rating' => $this->ratings_average_formatted,
        ];
    }
}
