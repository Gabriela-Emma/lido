<span class="flex {{$direction ?? 'flex-row'}} gap-8 items-center">
    @if($post->hero)
        <span class="block flex-shrink-0">
            <a href="{{$post->link}}">
                <img class="w-32 h-20 object-cover rounded-tl-[7rem] rounded-tr-[5rem] rounded-br-[4rem] rounded-bl-[0.5rem] bg-teal-600 filter hover:contrast-200 "
                     srcset="{{$post->hero?->getSrcset('thumbnail')}}"
                     src="{{$post->hero?->getUrl('thumbnail')}}"
                     alt="{{$post->hero?->name}}" />
            </a>
        </span>
    @endif
    <div class="min-w-0 flex-1">
        <div class="flex flex-row mb-1">
            @if($post->categories->isNotEmpty())
                <x-public.post-taxonomies textColor="text-white" :tax="$post->categories->first()"></x-public.post-taxonomies>
            @endif
        </div>
        <h3 class="font-medium text-black line-clamp-1 xl:line-clamp-2">
            <a href="{{$post->link}}">
                {{$post->title}}
            </a>
        </h3>

        <div class="py-2">
            <x-public.post-meta :post="$post"></x-public.post-meta>
        </div>

        <div class="mt-1 text-sm text-gray-700 line-clamp-4 lg:line-clamp-2 2xl:line-clamp-3">
            @if($post->excerpt)
                <x-markdown>{{$post->excerpt}}</x-markdown>
            @else
                <x-markdown>{{Str::words($post->content, $post->hero ? 30 : 40)}}</x-markdown>
            @endif
        </div>
    </div>
</span>
