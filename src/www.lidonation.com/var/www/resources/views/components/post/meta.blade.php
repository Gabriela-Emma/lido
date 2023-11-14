@props([
    'post',
    'size' => 'xs',
    'badge' => true
])
<?php
    $gravatarWidth = match ($size) {
        'sm' => "w-5",
        'md' => 'w-6',
        default => 'w-4'
    };
    $gravatarHeight = match ($size) {
        'sm' => "h-5",
        'md' => 'h-6',
        default => 'h-4'
    };
?>
<div class="flex flex-row gap-2">
    <div class="text-{{$size}} flex z-10 flex-row flex-wrap sm:flex-nowrap gap-x-2 gap-y-2 capitalize items-center post-meta">
        <time class="inline-flex items-center rounded-sm {{$badge ? 'bg-gray-100 px-1 py-0.5' : ''}}"
              datetime="{{$post->published_at_formatted}}">{{$post->published_at_formatted}}</time>
        <span class="inline-flex items-center rounded-sm {{$badge ? 'bg-gray-100 px-1 py-0.5' : ''}}">
            {{read_time($post->content)}}
        </span>
        <span class="block: sm:inline-flex items-center flex-shrink-0 rounded-sm gap-1 author {{$badge ? 'bg-gray-100 px-1 py-0.5' : ''}}">
            <span class="inline-block bio-pic">
                <img class="{{$gravatarHeight}} {{$gravatarWidth}} rounded-full"
                     src="{{$post->author?->gravatar}}"
                     title="{{$post->author?->name}}"
                     alt="{{$post->author?->name}} Bio Pic" />
            </span>
            <span class="author-name">
                {{$post->author?->name}}
            </span>
        </span>
    </div>
</div>
