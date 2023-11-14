@props([
    'post',
    'loop'
])

<div class="lg:row-span-2 lg:col-span-2">
    <div class="flex flex-col justify-start h-full article review">
        @if($post->hero)
            <div class="flex-shrink-0 hidden mb-4 md:inline-flex">
                <a href="{{$post->link}}">
                    @if($loop->first)
                        <img
                            class="object-cover w-full bg-teal-600 filter hover:contrast-200"
                            srcset="{{$post->hero?->getSrcset('large')}}"
                            src="{{$post->hero?->getUrl('large')}}"
                            alt="{{$post->hero?->name}}"/>
                    @else
                        <img
                            class="object-cover w-full bg-teal-600 filter hover:contrast-200"
                            srcset="{{$post->hero?->getSrcset('thumbnail')}}"
                            src="{{$post->hero?->getUrl('thumbnail')}}"
                            alt="{{$post->hero?->name}}"/>
                    @endif
                </a>
            </div>
        @endif

        <div class="flex flex-row mb-1">
            @if($post?->categories->isNotEmpty())
                <x-public.post-taxonomies
                    :tax="$post->categories->first()"></x-public.post-taxonomies>
            @endif
        </div>
        <h3 class="text-xl font-semibold text-gray-900 capitalize lg:text-2xl">
            <a href="{{$post->link}}"
                class="space-x-1 hover:text-teal-600 line-clamp-4 lg:line-clamp-2">
                    <span>
                        {{$post->title}}
                    </span>
                <span class="capitalize">
                        {{$snippets->review}}
                    </span>
            </a>
        </h3>

        <div class="py-1 mb-4">
            <span class="hidden md:w-5 md:h-5"></span>
            <x-public.stars :amount="$post?->ratings_average" :size="5"/>
        </div>

        <div
            class="overflow-x-hidden text-base text-gray-500 lg:line-clamp-4">
            <x-markdown>{{$post->summary}}</x-markdown>
        </div>
    </div>
</div>