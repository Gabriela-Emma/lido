<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePodcastSeasonRequest;
use App\Http\Requests\UpdatePodcastSeasonRequest;
use App\Models\PodcastSeason;

class PodcastSeasonController extends Controller
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
     * @param  \App\Http\Requests\StorePodcastSeasonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePodcastSeasonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PodcastSeason  $podcastSeason
     * @return \Illuminate\Http\Response
     */
    public function show(PodcastSeason $podcastSeason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PodcastSeason  $podcastSeason
     * @return \Illuminate\Http\Response
     */
    public function edit(PodcastSeason $podcastSeason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePodcastSeasonRequest  $request
     * @param  \App\Models\PodcastSeason  $podcastSeason
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePodcastSeasonRequest $request, PodcastSeason $podcastSeason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PodcastSeason  $podcastSeason
     * @return \Illuminate\Http\Response
     */
    public function destroy(PodcastSeason $podcastSeason)
    {
        //
    }
}
