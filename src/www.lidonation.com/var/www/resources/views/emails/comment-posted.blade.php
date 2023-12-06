@component('mail::message')
New comment posted to *{{$comment->model->title}}!*

Reply to keep the conversation going!

@component('mail::button', ['url' => $comment->model->link, 'color' => 'primary'])
Replay to Comment
@endcomponent

@endcomponent

