<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalystReportRequest;
use App\Http\Requests\UpdateCatalystReportRequest;
use App\Models\CatalystReport;
use Illuminate\Http\Response;

class CatalystReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
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
     * @param  StoreCatalystReportRequest  $request
     * @return void
     */
    public function store(StoreCatalystReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  CatalystReport  $catalystReport
     * @return Response
     */
    public function show(CatalystReport $catalystReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CatalystReport  $catalystReport
     * @return Response
     */
    public function edit(CatalystReport $catalystReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCatalystReportRequest  $request
     * @param  CatalystReport  $catalystReport
     * @return Response
     */
    public function update(UpdateCatalystReportRequest $request, CatalystReport $catalystReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CatalystReport  $catalystReport
     * @return Response
     */
    public function destroy(CatalystReport $catalystReport)
    {
        //
    }
}
