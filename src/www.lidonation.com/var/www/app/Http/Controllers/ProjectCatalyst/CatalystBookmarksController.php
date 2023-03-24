<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Http\Controllers\Controller;
use App\Models\BookmarkCollection;
use App\Models\BookmarkItem;
use App\Models\CatalystGroup;
use App\Models\CatalystUser;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;

class CatalystBookmarksController extends Controller
{
    protected int $perPage = 12;

    public function createItem(Request $request )
    {
        $modelTable = $request->get('model_type');
        $data = new Fluent($request->validate([
            'model_id' => "required|exists:{$modelTable},id",
            'parent_id' => "nullable|bail|hashed_exists:{$modelTable},id",
            'content' => 'nullable|bail|string',
            'link' => 'nullable|bail|active_url',
            'collection.hash' => 'nullable|bail|hashed_exists:bookmark_collections,id',
            'collection.title' => 'required_without:collection.hash|min:5'
        ]));

        // if collection doesn't exist, create one
        $collection = BookmarkCollection::byHash($data->collection['hash'] ?? null);

        if (!$collection instanceof BookmarkCollection) {
            $collection = new BookmarkCollection;
            $collection->title = $data->collection['title'] ?? null;
            $collection->content = $data->collection['content'] ?? null;
            $collection->visibility = 'unlisted';
            $collection->status = 'published';
            $collection->color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
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
        return $collection;
    }

    public function createCollection()
    {

    }


    public function view(Request $request, BookmarkCollection $bookmarkCollection)
    {
        return Inertia::render('BookmarkCollection')->with([
            'bookmarkCollection' => $bookmarkCollection,
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalystExplorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalystExplorer.bookmarks')],
                ['label' => $bookmarkCollection->title, 'link' => $bookmarkCollection->link]
            ],
        ]);
    }


    public function index(Request $request)
    {
        return Inertia::render('Bookmarks')->with([
            'crumbs' => [
                ['label' => 'Proposals', 'link' => route('catalystExplorer.proposals')],
                ['label' => 'Bookmarks', 'link' => route('catalystExplorer.bookmarks')]
            ],
        ]);
    }
}
