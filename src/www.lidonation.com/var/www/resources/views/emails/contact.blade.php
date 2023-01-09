@component('mail::message')
{{$message}}
@component('mail::panel')
Name: **{{$first_name}} {{$last_name}}**

Email: **{{$email}}**

Phone: **{{$phone}}**
@endcomponent
@endcomponent
