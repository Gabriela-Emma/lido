<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookmarkCollectionRequest;
use App\Http\Requests\UpdateBookmarkCollectionRequest;
use App\Models\BookmarkCollection;

class BookmarkCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookmarkCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookmarkCollectionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookmarkCollection  $bookmarkCollection
     * @return \Illuminate\Http\Response
     */
    public function show(BookmarkCollection $bookmarkCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookmarkCollection  $bookmarkCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(BookmarkCollection $bookmarkCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookmarkCollectionRequest  $request
     * @param  \App\Models\BookmarkCollection  $bookmarkCollection
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookmarkCollectionRequest $request, BookmarkCollection $bookmarkCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookmarkCollection  $bookmarkCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookmarkCollection $bookmarkCollection)
    {
        //
    }
}
