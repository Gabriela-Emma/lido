@props([
    'showHero',
    'post' => null
])

@isset($post)
<div class="flex flex-col h-full justify-start article post">
    @if(isset($showHero) && $post->hero)
        <div class="mb-4 flex-shrink-0 hero-wrapper">
            <a href="{{$post->link}}">
                <x-post.square-image :post="$post"></x-post.square-image>
            </a>
        </div>
    @endif

    <div class="flex flex-row flex-wrap gap-2 mb-1">
        @if($post?->categories->isNotEmpty())
            <x-public.post-taxonomies :tax="$post->categories->first()"></x-public.post-taxonomies>
        @endif
        @if($post->tags->isNotEmpty())
            @foreach($post->tags?->take(2) as $tax)
                <x-public.post-taxonomies bgColor="bg-slate-200" :tax="$tax"></x-public.post-taxonomies>
            @endforeach
        @endif
    </div>
    <h3 class="text-xl font-semibold text-gray-900">
        <a href="{{$post->link}}" class="hover:text-teal-600 line-clamp-4 lg:line-clamp-2">
            {{$post->title}}
        </a>
    </h3>

    @if($post->subtitle)
        <p class='text-lg subtitle relative font-medium'>
            {{ $post->subtitle }}
        </p>
    @endif

    <div class="py-2 mb-4">
        <x-public.post-meta :post="$post"></x-public.post-meta>
    </div>

    <div class="text-sm mt-auto">
        <x-public.continue-reading :link="$post->link"></x-public.continue-reading>
    </div>
</div>
@endisset
