@component('mail::message')
## New Content Idea submitted:
{{$post->content_contributed_idea}}

@component('mail::panel')
Title: **{{$post->title}}**
@endcomponent

@component('mail::button', ['url' => url(config('nova.path') . "/resources/articles/{$post->id}"), 'color' => 'primary'])
View Idea
@endcomponent

@endcomponent
