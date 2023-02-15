<?php

namespace App\Mail;

use App\Models\CatalystUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

class CatalystProfileVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public CatalystUser $catalystUser)
    {
        //
//        Password::createToken()

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $token =  Password::createToken($this->catalystUser?->claimedBy);
        $email =  $this->catalystUser->claimedBy->email;
        $setPasswordLink = route('password.reset', compact('token', 'email')); // . $token . '?email=' . urlencode($this->catalystUser->claimedBy->email);

        return $this
            ->from(config('mail.from'))
            ->markdown('emails.catalyst-profile-verified')
            ->subject(__('Catalyst Explorer: Profile Claim Verified!'))
            ->with(compact('setPasswordLink'));
    }
}
