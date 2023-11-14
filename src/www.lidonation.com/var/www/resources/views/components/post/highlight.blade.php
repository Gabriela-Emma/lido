<div class="lg:grid lg:grid-cols-7 gap-8 items-start col-span-2 xl:col-span-3 2xl:col-span-4">
    @if($post->hero)
        <div class="col-span-3 overflow-hidden max-h-[32rem]">
            <a href="{{$post->link}}">
                <img class="img-fluid"
                     srcset="{{$post->hero?->getSrcset('large')}}"
                     src="{{$post->hero?->getUrl('large')}}"
                     alt="{{$post->hero?->name}}"/>
            </a>
        </div>
    @endif
    <div class="article mt-4 {{$post->hero ? 'col-span-4' : 'col-span-7' }}">
        <div class="flex flex-row mb-1">
            @if($post->categories->isNotEmpty())
                <x-public.post-taxonomies textColor="text-white" :tax="$post->categories->first()"></x-public.post-taxonomies>
            @endif
        </div>
        <h3 class="text-3xl pt-4 lg:pt-0 font-semibold text-gray-900">
            <a href="{{$post->link}}" class="hover:text-teal-600">
                {{$post->title}}
            </a>
        </h3>
        <div class="py-2">
            <x-public.post-meta :post="$post"></x-public.post-meta>
        </div>

        <x-markdown>
            {{Str::words($post->content, $post->hero ? 120 : 200)}}
        </x-markdown>

        <div class="my-2 text-sm mt-auto">
            <x-public.continue-reading theme="primary" :link="$post->link" ></x-public.continue-reading>
        </div>
    </div>
</div>
