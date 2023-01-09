<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasWallets;
use App\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JetBrains\PhpStorm\Pure;

/**
 * @property Collection $wallets
 * @property int $id
 * @property int $amount
 * @property string $status
 * @property bool $submitted
 * @property Cause $cause
 */
class Vote extends Model
{
    use HasAuthor, HasWallets, SoftDeletes;

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class, 'cause_id');
    }

    #[Pure]
 public function getSubmittedAttribute(): bool
 {
     return $this->status === 'submitted';
 }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new OwnerScope);
    }
}
