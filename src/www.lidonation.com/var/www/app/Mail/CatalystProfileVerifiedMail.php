<?php

namespace App\Mail;

use App\Models\CatalystUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->from($this->catalystUser?->notification_email, $this->catalystUser?->name)
            ->markdown('emails.catalyst-profile-verified')
            ->subject(__('Catalyst Explorer: Profile Claim Verified!'));
    }
}
