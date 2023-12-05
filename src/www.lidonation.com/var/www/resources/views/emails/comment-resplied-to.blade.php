@component('mail::message')
## Your comment posted to {{$comment->model->title}} has been replied to!

@component('mail::panel')
{{$comment->name}}'s reply:
{{$comment->content}}
@endcomponent

Thank you for starting a conversation!

@component('mail::button', ['url' => $comment->model->link, 'color' => 'primary'])
Continue the conversation
@endcomponent

@endcomponent
