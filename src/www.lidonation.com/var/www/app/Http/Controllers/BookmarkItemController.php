<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookmarkItemRequest;
use App\Http\Requests\UpdateBookmarkItemRequest;
use App\Models\BookmarkItem;

class BookmarkItemController extends Controller
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
     * @param  \App\Http\Requests\StoreBookmarkItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookmarkItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookmarkItem  $bookmarkItem
     * @return \Illuminate\Http\Response
     */
    public function show(BookmarkItem $bookmarkItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookmarkItem  $bookmarkItem
     * @return \Illuminate\Http\Response
     */
    public function edit(BookmarkItem $bookmarkItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookmarkItemRequest  $request
     * @param  \App\Models\BookmarkItem  $bookmarkItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookmarkItemRequest $request, BookmarkItem $bookmarkItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookmarkItem  $bookmarkItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookmarkItem $bookmarkItem)
    {
        //
    }
}
