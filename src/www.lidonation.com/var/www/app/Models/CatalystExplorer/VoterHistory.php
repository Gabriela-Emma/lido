<?php

namespace App\Models\CatalystExplorer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CatalystExplorer\CatalystVoter;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VoterHistory extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    public function wallet():BelongsTo
    {
       return  $this->belongsTo(Wallet::class,'wallet_id');
    }

    public function voter():HasOne
    {
        return $this->hasOne(CatalystVoter::class,'cat_id','caster');
    }
}
