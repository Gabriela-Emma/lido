<div class="flex flex-col h-full justify-start article">
    @if(@isset($showHero) && $post->hero)
        <div class="mb-4 flex-shrink-0">
            <a href="{{$post->link}}">
                <img class="w-full object-cover bg-teal-600 filter hover:contrast-200 "
                     srcset="{{$post->hero?->getSrcset('thumbnail')}}"
                     src="{{$post->hero?->getUrl('thumbnail')}}"
                     alt="{{$post->hero?->name}}" />
            </a>
        </div>
    @endif

    <div class="flex flex-row mb-1">
        @if($post?->categories->isNotEmpty())
            <x-public.post-taxonomies :tax="$post->categories->first()"></x-public.post-taxonomies>
        @endif
    </div>
    <h3 class="text-2xl font-semibold text-gray-900">
        <a href="/posts/{{$post->slug}}/" class="hover:text-teal-600 line-clamp-4 lg:line-clamp-2">
            {{$post->title}}
        </a>
    </h3>

    <div class="py-2 mb-4">
        <x-public.post-meta :post="$post"></x-public.post-meta>
    </div>

    <div class="overflow-x-hidden lg:line-clamp-5">
        <x-markdown>{{$post->summary}}</x-markdown>
    </div>

    <div class="text-sm mt-auto">
        <x-public.continue-reading :link="$post->url"></x-public.continue-reading>
    </div>
</div>
