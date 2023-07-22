<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Exports\BookmarksCollectionExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookmarkCollectionResource;
use App\Models\BookmarkCollection;
use App\Models\BookmarkItem;
use App\Models\DraftBallot;
use App\Models\Proposal;
use App\Services\ExportModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Inertia\Inertia;

class CatalystMyBookmarksController extends Controller
{
    protected int $perPage = 12;

    public function createItem(Request $request)
    {
        DB::beginTransaction();
        try {
            $modelTable = $request->get('model_type');

            $data = new Fluent($request->validate([
                'model_id' => "required|exists:{$modelTable},id",
                'parent_id' => "nullable|bail|hashed_exists:{$modelTable},id",
                'content' => 'nullable|bail|string',
                'link' => 'nullable|bail|active_url',
                'collection.hash' => 'nullable|bail',
                'collection.title' => 'required_without:collection.hash|min:5',
            ]));

            // if collection doesn't exist, create one
            $collection = BookmarkCollection::byHash($data->collection['hash'] ?? null) ?? DraftBallot::byHash($data->collection['hash'] ?? null);

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

            DB::commit();

            $collection->refresh();
            $collection->load(['items']);

            return $collection->toArray();
            // return new BookmarkCollectionResource($collection);
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('There was an Error');
        }
    }

    public function view(Request $request, BookmarkCollection $bookmarkCollection)
    {
        return Inertia::render('BookmarkCollection')->with([
            'bookmarkCollection' => new BookmarkCollectionResource($bookmarkCollection),
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalystExplorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalystExplorer.bookmarks')],
                ['label' => $bookmarkCollection->title, 'link' => $bookmarkCollection->link],
            ],
        ]);
    }

    public function index(Request $request)
    {
        $collections = BookmarkCollection::where('user_id', Auth::id())->whereNotNull('user_id')->with(['items']);

        $hashes = $request->get('hashes', false);

        if ($hashes) {
            $collections = $collections->whereHashIn($hashes);
        }

        return $collections->get(['id', 'title', 'items.id'])->toArray();
    }

    public function deleteCollection(Request $request)
    {
        $collection = BookmarkCollection::byHash($request->hash);
        $this->authorize('delete', $collection);

        $collection->items()->delete();
        $collection->delete();
    }

    public function deleteItem(BookmarkItem $bookmarkItem)
    {
        $this->authorize('delete', $bookmarkItem);
        $bookmarkItem->delete();
    }

    public function exportBookmarks(Request $request)
    {
        $collection = BookmarkCollection::byHash($request->hash);
        $itemsArr = $collection->items()->pluck('id');

        return (new ExportModelService)->export(new BookmarksCollectionExport($itemsArr, $request->locale), $collection->title.'-proposals.csv');
    }
}
