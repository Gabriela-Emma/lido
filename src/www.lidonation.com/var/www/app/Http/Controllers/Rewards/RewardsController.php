<?php

namespace App\Http\Controllers\Rewards;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardsController extends Controller
{
    public function index()
    {
        return Inertia::render('Rewards');
    }
}
