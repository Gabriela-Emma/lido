<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalystGroupRequest;
use App\Http\Requests\UpdateCatalystGroupRequest;
use App\Models\CatalystGroup;

class CatalystGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreCatalystGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCatalystGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CatalystGroup  $catalystGroup
     * @return \Illuminate\Http\Response
     */
    public function show(CatalystGroup $catalystGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CatalystGroup  $catalystGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(CatalystGroup $catalystGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCatalystGroupRequest  $request
     * @param  \App\Models\CatalystGroup  $catalystGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCatalystGroupRequest $request, CatalystGroup $catalystGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CatalystGroup  $catalystGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatalystGroup $catalystGroup)
    {
        //
    }
}
