<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGiveawayRequest;
use App\Http\Requests\UpdateGiveawayRequest;
use App\Models\Giveaway;
use Illuminate\Http\Response;

class GiveawayController extends Controller
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
     * @return Response
     */
    public function store(StoreGiveawayRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Giveaway $giveaway)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Giveaway $giveaway)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UpdateGiveawayRequest $request, Giveaway $giveaway)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Giveaway $giveaway)
    {
        //
    }
}
