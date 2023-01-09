<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Newsletter\Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request, Newsletter $newsletter): RedirectResponse
    {
        $newsletter->subscribe($request->input('emailAddress'));

        return back()->withInput();
    }
}
