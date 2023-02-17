<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\CatalystReport;
use App\Models\Comment;
use App\Models\LegacyComment;
use App\Models\NotificationRequestTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function listComments(Request $request, CatalystReport $catalystReport) {
//        dd($catalystReport?->comments->toArray());
        return $catalystReport?->comments?->toArray();
    }

    public function createComment(Request $request, CatalystReport $catalystReport) {
        $validated = new Fluent($request->validate([
//            'name' => 'required',
//            'email' => 'required|email|unique:users,email',
            'comment' => 'required'
        ]));
        $catalystReport->comment($validated->comment, Auth::user());
        return to_route('catalystExplorer.reports');
    }

    public function follow(Request $request)
    {
        $validated = new Fluent($request->validate([
            'where' => 'email:rfc,dns',
            'name' => 'required',
            'filter' => 'required',
            'value' => 'required',
        ]));

        $nrt = new NotificationRequestTemplate;
        $nrt->where = $validated->where;

        // get authenticated user or create new one
        $who = User::where('email', $validated->where)?->first();
        if (! $who instanceof User) {
            $who = new User;
            $who->name = $validated->name;
            $who->email = $validated->where;
            $who->password = Hash::make(Str::random(30)) ?? null;
            $who->save();
        }
        $nrt->who_id = $who->id;
        $nrt->who_type = $who::class;

        $nrt->what_type = CatalystReport::class;
        $nrt->when = 'create';

        $nrt->what_filter = [
            'filterFunction' => 'whereRelation',
            'operator' => '=',
            'relation' => match ($validated->filter) {
                'proposal' => 'proposal',
                'group' => 'proposal.groups',
                'author' => 'proposal.author',
                default => $validated->filter
            },
            'field' => match ($validated->filter) {
                'proposal', 'group', 'author' => 'id',
                default => $validated->filter
            },
            'value' => $validated->value,
        ];

        $nrt->status = 'published';

        $nrt->save();

        return $nrt;
    }
}
