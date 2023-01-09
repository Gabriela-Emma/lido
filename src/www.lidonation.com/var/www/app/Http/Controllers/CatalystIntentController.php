<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalystIntentRequest;
use App\Http\Requests\UpdateCatalystIntentRequest;
use App\Models\CatalystIntent;

class CatalystIntentController extends Controller
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
     * @param  \App\Http\Requests\StoreCatalystIntentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCatalystIntentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CatalystIntent  $catalystIntent
     * @return \Illuminate\Http\Response
     */
    public function show(CatalystIntent $catalystIntent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CatalystIntent  $catalystIntent
     * @return \Illuminate\Http\Response
     */
    public function edit(CatalystIntent $catalystIntent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCatalystIntentRequest  $request
     * @param  \App\Models\CatalystIntent  $catalystIntent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCatalystIntentRequest $request, CatalystIntent $catalystIntent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CatalystIntent  $catalystIntent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatalystIntent $catalystIntent)
    {
        //
    }
}
