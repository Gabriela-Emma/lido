@component('mail::message')
{{$message}}
@component('mail::panel')
Name: **{{$firstname}} {{$lastname}}**

Email: **{{$email}}**

Phone: **{{$telephone}}**
@endcomponent
@endcomponent
