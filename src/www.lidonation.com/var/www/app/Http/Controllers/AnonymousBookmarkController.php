<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnonymousBookmarkRequest;
use App\Http\Requests\UpdateAnonymousBookmarkRequest;
use App\Models\AnonymousBookmark;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LZCompressor\LZString;

class AnonymousBookmarkController extends Controller
{
    public function share(Request $request)
    {
        $request->validate([
            'bookmark' => 'required|min:300',
        ]);
        $bookmark = $request->input('bookmark');

//        $bookmark = LZString::decompressFromEncodedURIComponent($bookmark);

        return AnonymousBookmark::updateOrCreate(
            [
                'bookmark' => $bookmark,
            ],
            [
                'bookmark' => $bookmark,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnonymousBookmarkRequest  $request
     * @return Response
     */
    public function store(StoreAnonymousBookmarkRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return AnonymousBookmark
     */
    public function show(AnonymousBookmark $anonymousBookmark): AnonymousBookmark
    {
        return $anonymousBookmark;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return Response
     */
    public function edit(AnonymousBookmark $anonymousBookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnonymousBookmarkRequest  $request
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return Response
     */
    public function update(UpdateAnonymousBookmarkRequest $request, AnonymousBookmark $anonymousBookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AnonymousBookmark  $anonymousBookmark
     * @return Response
     */
    public function destroy(AnonymousBookmark $anonymousBookmark)
    {
        //
    }
}
