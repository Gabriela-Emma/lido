<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTxRequest;
use App\Http\Requests\UpdateTxRequest;
use App\Models\Tx;

class TxController extends Controller
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
     * @param  \App\Http\Requests\StoreTxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTxRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tx  $tx
     * @return \Illuminate\Http\Response
     */
    public function show(Tx $tx)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tx  $tx
     * @return \Illuminate\Http\Response
     */
    public function edit(Tx $tx)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTxRequest  $request
     * @param  \App\Models\Tx  $tx
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTxRequest $request, Tx $tx)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tx  $tx
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tx $tx)
    {
        //
    }
}
