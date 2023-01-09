<?php

namespace App\Notifications;

// extends  Spatie\Comments\Notifications\NewCommentNotification
class NewCommentNotification 
{
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'comment' => $this->comment,
        ];
    }
}
