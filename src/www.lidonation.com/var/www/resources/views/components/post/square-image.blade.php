@props([
    'post' => null,
])
<img class="w-full object-cover bg-teal-600 filter hover:contrast-200 "
     srcset="{{$post->hero?->getSrcset('thumbnail')}}"
     src="{{$post->hero?->getUrl('thumbnail')}}"
     alt="{{$post->hero?->name}}" />
