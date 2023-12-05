@component('mail::message')
## A Content Idea has been claimed!

Use the <a href="{{$post->content_contributed_link}}">document link</a> to collaborate and edit.
When approved, copy text to voltaire, then approve in voltaire.


Approving in voltaire will remove article from the Content Manager view and set status to draft until
it's ready to be published.

@component('mail::panel')
Title: **{{$post->title}}**

Author Email: **{{$post->content_contributed_email}}**

Author Comments:
_{{$post->content_contributed_comments}}_
@endcomponent
@component('mail::button', ['url' => url(config('nova.path') . "/resources/articles/{$post->id}"), 'color' => 'primary'])
View Content
@endcomponent
@endcomponent
