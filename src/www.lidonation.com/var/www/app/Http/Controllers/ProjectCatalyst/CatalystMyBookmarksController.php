<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

class CatalystMyBookmarksController extends Controller
{
    protected int $perPage = 12;

    public function createItem(Request $request )
    {
        $data = $request->validate([
            'email' => 'sometimes|email',
            'twitter' => 'nullable|bail|min:2',
            'github' => 'nullable|bail|min:5',
            'discord' => 'nullable|bail|min:4',
            'telegram' => 'nullable|bail|min:2',
            'bio' => 'min:20',
        ]);
    }

    public function createCollection(CatalystUser $catalystUser )
    {

    }


    public function index(Request $request)
    {

    }
}
