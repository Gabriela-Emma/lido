<?php

namespace App\Inertia\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookmarkCollectionResource;
use App\Http\Resources\DraftBallotResource;
use App\Models\BookmarkCollection;
use App\Models\BookmarkItem;
use App\Models\CatalystExplorer\Proposal;
use App\Models\Discussion;
use App\Models\DraftBallot;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;

class BookmarksController extends Controller
{
    protected int $perPage = 12;

    public function createItem(Request $request): array|\JsonSerializable|Arrayable
    {
        $modelTable = $request->get('model_type');
        $data = new Fluent($request->validate([
            'model_id' => "required|exists:{$modelTable},id",
            'parent_id' => "nullable|bail|hashed_exists:{$modelTable},id",
            'content' => 'nullable|bail|string',
            'link' => 'nullable|bail|active_url',
            'collection.hash' => 'nullable|bail|hashed_exists:bookmark_collections,id',
            'collection.title' => 'required_without:collection.hash|min:5',
        ]));

        // if collection doesn't exist, create one
        $collection = BookmarkCollection::byHash($data->collection['hash']) ?? DraftBallot::byHash($data->collection['hash']) ?? null;

        if (! $collection instanceof BookmarkCollection) {
            $collection = new BookmarkCollection;
            $collection->title = $data->collection['title'] ?? null;
            $collection->content = $data->collection['content'] ?? null;
            $collection->visibility = 'unlisted';
            $collection->status = 'published';
            $collection->user_id = Auth::id();
            $collection->color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $collection->save();
        }

        $modelType = match ($modelTable) {
            'proposals' => Proposal::class
        };

        // create item
        $item = new BookmarkItem;
        $item->bookmark_collection_id = $collection->raw_id;
        $item->model_id = $data->model_id;
        $item->model_type = $data->model_type ?? $modelType;
        $item->parent_id = $data->parent_id;
        $item->content = $data->content;
        $item->link = $data->link;
        $item->save();

        $collection->refresh();
        $collection->load(['items']);

        if ($collection instanceof DraftBallot) {
            return (new DraftBallotResource($collection))->toArray($request);
        }

        return (new BookmarkCollectionResource($collection))->toArray($request);
    }

    public function view(Request $request, BookmarkCollection $bookmarkCollection): Response|RedirectResponse
    {
        if ($bookmarkCollection instanceof DraftBallot) {
            return to_route('catalyst-explorer.draftBallot.view', $bookmarkCollection->hash);
        }
        $bookmarkCollection->load(['items.model']);

        return Inertia::render('BookmarkCollection')->with([
            'bookmarkCollection' => (new BookmarkCollectionResource($bookmarkCollection))
                ->toArray($request),
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalyst-explorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalyst-explorer.myBookmarks')],
                ['label' => $bookmarkCollection->title, 'link' => $bookmarkCollection->link],
            ],
        ]);
    }

    public function viewDraftBallot(Request $request, DraftBallot $draftBallot): Response
    {
        return Inertia::render('DraftBallot')->with([
            'draftBallot' => (new DraftBallotResource($draftBallot))->toArray($request),
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalyst-explorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalyst-explorer.myDraftBallots')],
                ['label' => $draftBallot->title, 'link' => $draftBallot->link],
            ],
        ]);
    }

    public function viewUpdateDraftBallot(DraftBallot $draftBallot)
    {
        return Inertia::modal('UpdateDraftBallot')
            ->with([
                'draftBallot' => $draftBallot,
            ])
            ->baseRoute('catalyst-explorer.draftBallot.edit', [
                'draftBallot' => $draftBallot->hash,
            ]);
    }

    public function getDraftBallot(Request $request, DraftBallot $draftBallot)
    {
        return (new DraftBallotResource($draftBallot))->toArray($request);
    }

    public function draftBallotIndex()
    {
        return DraftBallot::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->fastPaginate(24);
    }

    public function editDraftBallot(Request $request, DraftBallot $draftBallot): Response
    {
        if (! Gate::allows('update', $draftBallot)) {
            abort(403);
            // return redirect()->route('catalyst-explorer.login');
        }

        return Inertia::render('EditDraftBallot')->with([
            'draftBallot' => (new DraftBallotResource($draftBallot))->toArray($request),
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalyst-explorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalyst-explorer.myDraftBallots')],
                ['label' => $draftBallot->title, 'link' => $draftBallot->link],
            ],
        ]);
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Bookmarks')->with([
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalyst-explorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalyst-explorer.myBookmarks')],
            ],
        ]);
    }

    public function createDraftBallot(Request $request): RedirectResponse
    {
        $db = new DraftBallot;
        $db->user_id = Auth::id();
        $db->title = auth()?->user()->name.' Draft Ballot';
        $db->visibility = 'unlisted';
        $db->status = 'published';
        $db->color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        $db->save();

        return to_route(
            'catalyst-explorer.draftBallot.edit',
            $db->hash
        );
    }

    public function updateDraftBallot(DraftBallot $draftBallot, Request $request): RedirectResponse
    {
        $draftBallot->title = request('title');
        $draftBallot->color = request('color');
        $draftBallot->content = request('content');
        $draftBallot->save();

        return to_route(
            'catalyst-explorer.draftBallot.edit',
            $draftBallot->hash
        );
    }

    public function createDraftBallotFromCollection(Request $request, BookmarkCollection $bookmarkCollection)
    {
        $bookmarkCollection->type = DraftBallot::class;
        $bookmarkCollection->save();
        $db = DraftBallot::find($bookmarkCollection->id);

        return to_route(
            'catalyst-explorer.draftBallot.edit',
            $db->hash
        );
    }

    public function storeDraftBallotRationale(Request $request, BookmarkCollection $bookmarkCollection)
    {
        $data = $request->validate([
            'rationale' => 'required|string',
            'group_id' => 'required|int',
            'title' => 'nullable',
        ]);

        // user meta data to attach to the fund_id (challenge id)
        $rationale = $bookmarkCollection->rationales()
            ->whereRelation('metas', 'key', '=', 'group_id')
            ->whereRelation('metas', 'content', '=', $data['group_id'])->first();

        if (! $rationale instanceof Discussion) {
            $rationale = new Discussion;
            $rationale->user_id = Auth::id();
            $rationale->model_type = BookmarkCollection::class;
            $rationale->model_id = $bookmarkCollection->id;
            $rationale->status = 'published';
        }
        $rationale->title = $data['title'];
        $rationale->content = $data['rationale'];
        $rationale->save();
        $rationale->saveMeta('group_id', $data['group_id'], $rationale);

        return redirect()->back();
    }

    public function deleteDraftBallot(Request $request, BookmarkCollection $bookmarkCollection)
    {
        $bookmarkCollection->delete();

        foreach ($bookmarkCollection->items as $bookmarkItem) {
            $bookmarkItem->delete();
        }

        return redirect()->back();
    }
}
