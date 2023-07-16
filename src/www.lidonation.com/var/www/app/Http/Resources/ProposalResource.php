<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProposalResource extends JsonResource
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
            'user_id' => $this->user_id,
            'fund_id' => $this->fund?->parent_id,
            'fund_name' => $this->fund?->parent?->title,
            'challenge_id' => $this->fund_id,
            'challenge_name' => $this->fund?->title,
            'title' => $this->title,
            'website' => $this->website,
            'link' => $this->link,
            'embedded_uris' => $this->embeddedUris($this->content),
            'ideascale_link' => $this->ideascale_link,
            'ideascale_user' => Str::remove(' ', $this->author?->username),
            'ideascale_id' => (int) $this->meta_data?->ideascale_id,
            'average_rating' => $this->ratings_average_formatted,
            'amount_requested' => $this->amount_requested,
            'amount_received' => $this->amount_received,
            'project_status' => $this->status,
            'funding_status' => $this->funding_status,
            'yes_votes_count' => $this->yes_votes_count,
            'no_votes_count' => $this->no_votes_count,
            'unique_wallets' => (int) $this->meta_data?->unique_wallets,
            'type' => $this->type,
            'problem' => $this->problem,
            'solution' => $this->solution,
            'experience' => $this->experience,
            'tags' => $this->tags,
            'currency_symbol' => $this->currency_symbol,
            'currency' => $this->currency,
            'vote' => $this->vote,
        ];
    }

    protected function embeddedUris($str)
    {
        $pattern = '/(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)(?:\([-a-zA-Z0-9+&@#\/%=~_|$?!:,.]*\)|[-a-zA-Z0-9+&@#\/%=~_|$?!:,.])*(?:\([-a-zA-Z0-9+&@#\/%=~_|$?!:,.]*\)|[a-zA-Z0-9+&@#\/%=~_|$])/';
        preg_match_all($pattern, $str, $uris);

        return $uris;
    }
}
