@props([
    'post'
])

<div class="flex flex-row gap-4">
    @if($post->hero)
        <a class="flex-shrink-0 block w-40 sm:w-64" href="{{$post->link}}">
            <x-post.drip-image :post="$post"></x-public.post.drip-image>
        </a>
    @endif
    <div class="flex flex-col gap-1 pt-4">
        @if( $post->categories->isNotEmpty() || $post->tags->isNotEmpty())
            <div class="flex flex-row flex-wrap justify-start gap-2 sm:max-w-md">
                <x-public.post-type :post="$post"></x-public.post-type>

                @if($post->categories->isNotEmpty())
                    @foreach($post->categories as $tax)
                        <x-public.post-taxonomies :tax="$tax"></x-public.post-taxonomies>
                    @endforeach
                @endif
                @if($post->tags->isNotEmpty())
                    @foreach($post->tags as $tax)
                        <x-public.post-taxonomies bgColor="bg-white"
                                                    :tax="$tax"></x-public.post-taxonomies>
                    @endforeach
                @endif
            </div>
        @endif

        <h3 class="p-0 text-lg font-medium sm:text-xl lg:text-3xl xl:text-4xl 2xl:text-5xl">
            <a class="text-gray-700" href="{{$post->link}}" wire:navigate.hover>
                {{$post->title}}
            </a>
        </h3>

        @if($post->subtitle)
            <p class='relative text-xl font-medium xl:text-2xl subtitle'>
                {{ $post->subtitle }}
            </p>
        @endif

        <div class="py-2 mb-4">
            <x-public.post-meta :post="$post"></x-public.post-meta>
        </div>
    </div>
</div>
