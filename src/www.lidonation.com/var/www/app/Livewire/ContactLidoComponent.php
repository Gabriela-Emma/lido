<?php

namespace App\Livewire;

use App\Mail\ContactFormSubmittedMail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactLidoComponent extends Component
{
    public $firstname;

    public $lastname;

    public $telephone;

    public $email;

    public $subject;

    public $message;

    public function render(): Factory|View|Application
    {
        return view('livewire.components.contact-lido');
    }

    public function submitForm()
    {
        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10',
        ]);

        Mail::to('hello@lidonation.com')
            ->send(new ContactFormSubmittedMail([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'subject' => $this->subject,
                'message' => $this->message,
            ]));

        $this->reset();
        session()->flash('success', 'Your message has been sent successfully.');
    }
}
