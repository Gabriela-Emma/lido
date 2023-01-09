<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmittedMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')],
            'email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10',
        ]);

        Mail::to('hello@lidonation.com')
            ->send(new ContactFormSubmittedMail($request->input()));

        return back()->withInput();
    }
}
