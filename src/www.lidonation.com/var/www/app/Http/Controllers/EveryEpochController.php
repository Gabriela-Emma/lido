<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEveryEpochRequest;
use App\Http\Requests\UpdateEveryEpochRequest;
use App\Models\EveryEpoch;
use Illuminate\Http\Response;

class EveryEpochController extends Controller
{
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
     * @param  StoreEveryEpochRequest  $request
     * @return Response
     */
    public function store(StoreEveryEpochRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  EveryEpoch  $everyEpoch
     * @return Response
     */
    public function show(EveryEpoch $everyEpoch)
    {
        return $everyEpoch;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EveryEpoch  $everyEpoch
     * @return Response
     */
    public function edit(EveryEpoch $everyEpoch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEveryEpochRequest  $request
     * @param  EveryEpoch  $everyEpoch
     * @return Response
     */
    public function update(UpdateEveryEpochRequest $request, EveryEpoch $everyEpoch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EveryEpoch  $everyEpoch
     * @return Response
     */
    public function destroy(EveryEpoch $everyEpoch)
    {
        //
    }
}
