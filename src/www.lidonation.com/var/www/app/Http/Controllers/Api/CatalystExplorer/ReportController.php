<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CatalystReport;
use Illuminate\Support\Fluent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NotificationRequestTemplate;

class ReportController extends Controller
{
    public function listComments(Request $request, CatalystReport $catalystReport)
    {

        return $catalystReport?->comments?->toArray();
    }

    public function showReactions(Request $request, CatalystReport $catalystReport)
    {

        $reactions = [];
        $comments = $catalystReport->comments->where('text', '');
        foreach ($comments as $comment) {
            $reaction = $comment->reactions;
            $reactions = array_merge($reactions, $reaction->toArray());
        };

        $reactionCounts = array_count_values(array_column($reactions, 'reaction'));

        $reactionsObject = [];
        foreach ($reactionCounts as $reaction => $count) {
            $reactionsObject[] = [
                'catalystReport' => $catalystReport->id,
                'reaction' => $reaction,
                'count' => $count,
            ];
        };
        return $reactionsObject;
    }


    public function createComment(Request $request, CatalystReport $catalystReport)
    {
        $validated = new Fluent($request->validate([
            //            'name' => 'required',
            //            'email' => 'required|email|unique:users,email',
            'comment' => 'required',
        ]));
        $catalystReport->comment($validated->comment, Auth::user());

        return to_route('catalystExplorer.reports');
    }

    public function createReaction(Request $request, CatalystReport $catalystReport)
    {
        $user = Auth::user();
        $existingEmptyComment = $catalystReport->comments->where('commentator_id', $user->id)->where('text', '')->first();

        if ($existingEmptyComment) {
            return response()->json(['message' => 'You have already created an empty comment for this report.'], 422);
        }

        $validated = new Fluent($request->validate([
            'comment' => 'required',
        ]));
        $catalystReport->comment("", Auth::user())->react($validated->comment, Auth::user());

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
        if (!$who instanceof User) {
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
