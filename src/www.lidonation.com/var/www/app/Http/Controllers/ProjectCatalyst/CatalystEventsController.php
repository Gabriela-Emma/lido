<?php

namespace App\Http\Controllers\ProjectCatalyst;

use App\Enums\CatalystEventsFrequencyEnum;
use App\Enums\CatalystEventsKindEnum;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;

class CatalystEventsController extends Controller
{
    public function index(Request $request)
    {
        $props = [
            'crumbs' => [
                ['label' => 'Events']
            ]
        ];
        return Inertia::render('CatalystEvents', $props);
    }

    public function eventCreate(Request $request)
    {
        $validated = new Fluent($request->validate([
            'full_name' => 'required|min:3',
            'email' => 'required|email',
            'event_name' =>  'required|max:120',
            'date' => 'required',
        ]));

        $date = Carbon::parse($request->input('date'));
        $time = Carbon::parse('19:00:00');

        $startsAt = $date->copy();
        $startsAt->hour = $time->hour;
        $startsAt->minute = $time->minute;
        $startsAt->second = $time->second;

        $event = new Event();
        $event->name = $validated->event_name;
        $event->content = $request->description;
        $event->kind = CatalystEventsKindEnum::AFTER_HALL;
        $event->frequency = CatalystEventsFrequencyEnum::ONCE;
        $event->starts_at = $startsAt;

        $event->save();

        $entities = [
            'ath_host_name' => $validated->full_name,
            'ath_email' => $validated->email,
            'ath_co_host' => $request->cohost_name,
            'ath_twitter' => $request->twitter,
            'ath_website' => $request->website,
            'ath_discord' => $request->discord,
            'ath_address' => $request->address,
        ];
        
        foreach ($entities as $key => $value) {
            if ($value !== null) {
                $event->saveMeta($key, $value, $event, true);
            }
        }

        return redirect()->back();
    }
}
