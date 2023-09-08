<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CatalystLedgerSnapshotData extends Data
{
    public function __construct(
        public string $snapshot_id,

        public string $size,


    ) {
    }
}
