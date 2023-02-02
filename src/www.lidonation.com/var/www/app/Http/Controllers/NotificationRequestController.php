<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequestRequest;
use App\Http\Requests\UpdateNotificationRequestRequest;
use App\Models\NotificationRequest;

class NotificationRequestController extends Controller
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
     * @param  \App\Http\Requests\StoreNotificationRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationRequest  $notificationRequest
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationRequest $notificationRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationRequest  $notificationRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationRequest $notificationRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequestRequest  $request
     * @param  \App\Models\NotificationRequest  $notificationRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequestRequest $request, NotificationRequest $notificationRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationRequest  $notificationRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationRequest $notificationRequest)
    {
        //
    }
}
