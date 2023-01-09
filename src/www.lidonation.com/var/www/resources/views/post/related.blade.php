<div class="flex flex-col h-full justify-start article">
    @if($relatedPost->hero)
        <div class="mb-4 flex-shrink-0">
            <a href="{{$relatedPost->link}}">
                <img class="w-full object-cover rounded-tl-[14rem] rounded-tr-[12rem] rounded-br-[11rem] rounded-bl-[0.5rem] bg-teal-600 filter hover:contrast-200 "
                     srcset="{{$relatedPost->hero?->getSrcset('thumbnail')}}"
                     src="{{$relatedPost->hero?->getUrl('thumbnail')}}"
                     alt="{{$relatedPost->hero?->name}}" />
            </a>
        </div>
    @endif
    <div class="py-2">
        <x-public.post-meta :post="$relatedPost"></x-public.post-meta>
    </div>

    <h3 class="text-xl md:text-2xl leading-9 tracking-wider font-light text-gray-700">
        <a href="/posts/{{$relatedPost->slug}}/" class="hover:text-teal-600 line-clamp-4 lg:line-clamp-3">
            {{$relatedPost->title}}
        </a>
    </h3>
</div>
