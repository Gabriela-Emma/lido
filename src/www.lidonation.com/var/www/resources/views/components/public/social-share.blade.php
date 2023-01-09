@props([
    'post',
    'text' => 'cool article on @lidonation: ' . $post->social_post
])
<div>
    <h6 class="mb-2">Share</h6>
    <div class="flex flex-row gap-2">
        <a class="w-8 h-8" style="color: inherit"
           href="http://twitter.com/share?text={{$text}}&url={{$post->link}}&hashtags={{$post->hash_tags?->implode(',')}}"
           target="_blank">
            @include('svg.twitter')
        </a>
        <a href="//www.facebook.com/sharer/sharer.php?u={{$post->link}}" target="_blank"
           class="w-8 h-8"  style="color: inherit">
            @include('svg.facebook')
        </a>
    </div>
</div>
