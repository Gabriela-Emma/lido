<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalystReportRequest;
use App\Http\Requests\UpdateCatalystReportRequest;
use App\Models\CatalystReport;

class CatalystReportController extends Controller
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
     * @param  \App\Http\Requests\StoreCatalystReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCatalystReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CatalystReport  $catalystReport
     * @return \Illuminate\Http\Response
     */
    public function show(CatalystReport $catalystReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CatalystReport  $catalystReport
     * @return \Illuminate\Http\Response
     */
    public function edit(CatalystReport $catalystReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCatalystReportRequest  $request
     * @param  \App\Models\CatalystReport  $catalystReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCatalystReportRequest $request, CatalystReport $catalystReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CatalystReport  $catalystReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatalystReport $catalystReport)
    {
        //
    }
}
