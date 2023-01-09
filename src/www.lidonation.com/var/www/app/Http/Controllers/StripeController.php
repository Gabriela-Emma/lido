<?php

namespace App\Http\Controllers;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function getIntent(Request $request)
    {
        return Stripe::paymentIntents()->create([
            'amount' => floatval($request->input('amount')),
            'currency' => 'usd',
            'payment_method_types' => [
                'card',
            ],
        ]);
    }
}
