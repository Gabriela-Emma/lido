<?php

namespace App\Http\Controllers\ProjectCatalyst;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use App\Repositories\FundRepository;

class CatalystVoterToolController extends Controller
{
    public $fund;
    public $challenges;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->fund = app(FundRepository::class)->funds('inGovernance')->first();
        $this->challenges = app(FundRepository::class)->fundChallenges($this->fund);
    }


    public function index()
    {
        return Inertia::render('VoterTool1', [
            'challenges' =>$this->challenges,
            'fund' => $this->fund,
            'crumbs' => [
                ['label' => 'Voter Tool'],
            ],
        ]);
    }


}
