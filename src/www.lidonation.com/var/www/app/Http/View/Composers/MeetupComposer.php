<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use MacsiDigital\Zoom\Facades\Zoom;

class MeetupComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $today = new Carbon();
        $today->setTimezone(config('app.timezone'));
        $view->with([
            'dayOfWeek' => $today->dayOfWeek,
            'hourOfDay' => $today->format('H'),
            'meetups' => ['upcoming' => null], // Cache::remember('meetups', 86400, fn () => $this->getMeetups()),
        ]);
    }

    protected function getMeetups()
    {
        $meetups = ['upcoming' => null];
        try {
            $meetups = [
                'upcoming' => Zoom::user()
                    ->find(
                        config('zoom.zoom_default_meeting_user')
                    )->meetings()
                    ->where('type', 'upcoming')
                    ->first(),
            ];
        } catch (\Exception $e) {
            report($e);
        }

        return $meetups;
    }
}
