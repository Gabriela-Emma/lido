<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePodcastShowRequest;
use App\Http\Requests\UpdatePodcastShowRequest;
use App\Models\PodcastShow;

class PodcastShowController extends Controller
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
     * @param  \App\Http\Requests\StorePodcastShowRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePodcastShowRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PodcastShow  $podcastShow
     * @return \Illuminate\Http\Response
     */
    public function show(PodcastShow $podcastShow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PodcastShow  $podcastShow
     * @return \Illuminate\Http\Response
     */
    public function edit(PodcastShow $podcastShow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePodcastShowRequest  $request
     * @param  \App\Models\PodcastShow  $podcastShow
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePodcastShowRequest $request, PodcastShow $podcastShow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PodcastShow  $podcastShow
     * @return \Illuminate\Http\Response
     */
    public function destroy(PodcastShow $podcastShow)
    {
        //
    }
}
