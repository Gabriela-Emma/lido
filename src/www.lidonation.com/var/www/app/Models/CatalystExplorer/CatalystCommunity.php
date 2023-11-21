<?php declare(strict_types=1);

namespace App\Models\CatalystExplorer;

use App\Enums\StatusEnum;
use App\Models\Model;
use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalystCommunity extends Model
{
    use HasAuthor, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status',
    ];

    protected $casts = [
        'updated_at' => 'datetime:M d y',
        'created_at' => 'datetime:M d y',
        'status' => StatusEnum::class,
    ];

}
