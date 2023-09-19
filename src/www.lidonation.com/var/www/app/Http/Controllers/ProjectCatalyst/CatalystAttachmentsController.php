<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystSnapshot;
use App\Models\Fund;
use App\Models\Meta;
use Illuminate\Http\Request;

class CatalystAttachmentsController extends Controller
{
    protected function votingPowersAttachemnt(Request $request)
    {
        $snapshot = CatalystSnapshot::where('model_type', Fund::class)
            ->where('model_id', $request->input('fs'))
            ->first();

        $link = Meta::where('model_type', CatalystSnapshot::class)
            ->where('model_id', $snapshot->id)
            ->where('key', 'snapshot_file_path')
            ->first();

        if (! $link) {
            return null;
        }

        return '/storage/'.$link?->content;
    }
}
