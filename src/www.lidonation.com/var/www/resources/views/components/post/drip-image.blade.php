@props([
    'post'
])
<img class="w-full object-cover rounded-tl-[14rem] rounded-tr-[12rem] rounded-br-[11rem] rounded-bl-[0.5rem] bg-teal-600 filter hover:contrast-200 "
     srcset="{{$post->hero?->getSrcset('thumbnail')}}"
     src="{{$post->hero?->getUrl('thumbnail')}}"
     alt="{{$post->hero?->name}}" />
