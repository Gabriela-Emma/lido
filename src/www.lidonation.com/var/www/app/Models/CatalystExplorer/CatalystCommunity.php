<?php declare(strict_types=1);

namespace App\Models\CatalystExplorer;

use App\Enums\StatusEnum;
use App\Models\Model;
use App\Models\Traits\HasAuthor;

class CatalystCommunity extends Model
{
    use HasAuthor;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

}
