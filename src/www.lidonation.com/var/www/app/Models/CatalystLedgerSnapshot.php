<?php

namespace App\Models;

use App\Scopes\OrderByDateScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalystLedgerSnapshot extends Model
{

    public $guarded = [];

    public function fund(): BelongsTo
    {
        return $this->belongsTo(Fund::class, 'fund_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new OrderByDateScope);
    }
}
