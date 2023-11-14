<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystExplorer\CatalystSnapshot;
use App\Models\CatalystExplorer\Fund;
use App\Models\Meta;
use Illuminate\Http\Request;

class AttachmentsController extends Controller
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
