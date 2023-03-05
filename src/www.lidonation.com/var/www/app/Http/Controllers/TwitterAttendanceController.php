<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTwitterAttendanceRequest;
use App\Http\Requests\UpdateTwitterAttendanceRequest;
use App\Models\TwitterAttendance;
use App\Models\TwitterEvent;
use Illuminate\Http\Response;

class TwitterAttendanceController extends Controller
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
     * @return Response|TwitterAttendance
     */
    public function create()
    {
        $twitter_access_token = session('twitter_access_token');
        $event = TwitterEvent::first();
        $ta = TwitterAttendance::where('twitter_user_id', $twitter_access_token['user_id'])->first();
        if (! $ta instanceof  TwitterAttendance) {
            $ta = new TwitterAttendance;
        }
        $ta->stake_address = request()->get('stake_address');
        $ta->twitter_user_id = $twitter_access_token['user_id'];
        $ta->twitter_event_id = $event?->id;

        $ta->save();

        $ta->metas()->forceDelete();

        $rewardAddress = request()->get('reward_address');
        if ($rewardAddress != null) {
            $ta->saveMeta('reward_address', $rewardAddress, $ta, false);
        }

        $firstPrinciples = request()->get('firstPrinciples');
        if ($firstPrinciples != null) {
            $ta->saveMeta('giveaways', 'first_principles', $ta, false);
        }

        $copperSeed = request()->get('copperSeed');
        if ($copperSeed != null) {
            $ta->saveMeta('giveaways', 'copper_seed', $ta, false);
        }

        $resiToken = request()->get('resiToken');
        if ($resiToken != null) {
            $ta->saveMeta('giveaways', 'resi_token', $ta, false);
        }

        $cardaworlds = request()->get('cardaworlds');
        if ($cardaworlds != null) {
            $ta->saveMeta('giveaways', 'cardaworlds', $ta, false);
        }

        return $ta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreTwitterAttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(TwitterAttendance $twitterAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(TwitterAttendance $twitterAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UpdateTwitterAttendanceRequest $request, TwitterAttendance $twitterAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(TwitterAttendance $twitterAttendance)
    {
        //
    }
}
