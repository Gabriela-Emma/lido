<div class="flex flex-col-reverse col-span-2 xl:flex-row lg:grid lg:grid-cols-7 gap-8 items-start xl:col-span-3 2xl:col-span-4">
    <div class="article {{$post->hero ? 'col-span-4 xl:col-span-3' : 'col-span-7' }}">
        <div class="flex flex-row mb-1">
            @if($post->categories->isNotEmpty())
                <x-public.post-taxonomies textColor="text-white" :tax="$post->categories->first()"></x-public.post-taxonomies>
            @endif
        </div>
        <h3 class="text-4xl pt-4 lg:pt-0 font-semibold text-gray-900">
            <a href="/posts/{{$post->slug}}/" class="hover:text-teal-600">
                {{$post->title}}
            </a>
        </h3>
        <div class="py-2">
            <x-public.post-meta :post="$post"></x-public.post-meta>
        </div>

        <x-markdown>{{Str::words($post->content, $post->hero ? 180 : 220)}}</x-markdown>

        <div class="my-2 mt-auto text-sm">
            <x-public.continue-reading :link="$post->url"></x-public.continue-reading>
        </div>
    </div>

    @if($post->hero)
        <div class="col-span-3 xl:col-span-4 overflow-hidden">
            <a class="block" href="/posts/{{$post->slug}}/">
                <img class="img-fluid"
                     src="{{$post->hero?->getUrl()}}" alt="{{$post->hero?->name}}"/>
            </a>
        </div>
    @endif
</div>
