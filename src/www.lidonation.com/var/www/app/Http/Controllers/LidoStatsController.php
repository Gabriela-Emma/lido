<?php

namespace App\Http\Controllers;

use App\Invokables\LidoOriginStats;

class LidoStatsController extends Controller
{
    public int $newsArticles;

    public int $educationalArticles;

    public int $minutesOfAudioReadings;

    public int $hrsOfTwitterSpacesWork;

    public ?int $thirtyDaysPageViews;

    public int $thirtyDaysCatalystQueries;

    public function __construct()
    {
        [
            $this->newsArticles, $this->educationalArticles,
            $this->minutesOfAudioReadings, $this->hrsOfTwitterSpacesWork,
            $this->thirtyDaysPageViews, $this->thirtyDaysCatalystQueries
        ] = (new LidoOriginStats)();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'newsArticles' => $this->newsArticles,
            'educationalArticles' => $this->educationalArticles,
            'minutesOfAudioReadings' => $this->minutesOfAudioReadings,
            'hrsOfTwitterSpacesWork' => $this->hrsOfTwitterSpacesWork,
            'thirtyDaysPageViews' => $this->thirtyDaysPageViews,
            'thirtyDaysCatalystQueries' => $this->thirtyDaysCatalystQueries,
        ];
    }
}
