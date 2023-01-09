<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessorRequest;
use App\Http\Requests\UpdateAssessorRequest;
use App\Models\Assessor;

class AssessorController extends Controller
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
     * @param  \App\Http\Requests\StoreAssessorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssessorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assessor  $assessor
     * @return \Illuminate\Http\Response
     */
    public function show(Assessor $assessor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assessor  $assessor
     * @return \Illuminate\Http\Response
     */
    public function edit(Assessor $assessor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssessorRequest  $request
     * @param  \App\Models\Assessor  $assessor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssessorRequest $request, Assessor $assessor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assessor  $assessor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assessor $assessor)
    {
        //
    }
}
