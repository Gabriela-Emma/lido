<?php

namespace App\Models;

use App\Http\Traits\HasHashIds;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HashIdModel;
use App\Models\Traits\HasModel;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalystVote extends Model
{
    use HasAuthor, HasModel, HasHashIds, HashIdModel, HasTimestamps, SoftDeletes;

    protected $casts = [
        'vote' => 'integer',
    ];

    public function __invoke()
    {
        return $this->vote; // multiply by power
    }

    public function __toString()
    {
        return $this->vote;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            'model_id' => $this->model_id,
            // 'model_type' => $this->model_type,
            'content' => $this->content,
            'vote' => $this->vote,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
