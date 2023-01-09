<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTwitterEventRequest;
use App\Http\Requests\UpdateTwitterEventRequest;
use App\Models\TwitterEvent;

class TwitterEventController extends Controller
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
     * @param  \App\Http\Requests\StoreTwitterEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTwitterEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TwitterEvent  $twitterEvent
     * @return \Illuminate\Http\Response
     */
    public function show(TwitterEvent $twitterEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TwitterEvent  $twitterEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(TwitterEvent $twitterEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTwitterEventRequest  $request
     * @param  \App\Models\TwitterEvent  $twitterEvent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTwitterEventRequest $request, TwitterEvent $twitterEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TwitterEvent  $twitterEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(TwitterEvent $twitterEvent)
    {
        //
    }
}
