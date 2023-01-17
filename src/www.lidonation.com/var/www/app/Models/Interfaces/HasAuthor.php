<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasAuthor
{
    public function author(): BelongsTo;

    public function user(): BelongsTo;
}
