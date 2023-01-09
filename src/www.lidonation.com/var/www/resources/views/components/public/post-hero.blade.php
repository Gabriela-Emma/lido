@props([
    'post',
    'inArchive' => false,
    'size' => 'xs'
])
@if($post->hero)
<section class="hero-image overflow-visible z-10 relative py-0 lg:px-8 xl:px-0">
    <div class="relative">
        <img class="img-fluid rounded-tl-[16rem] lg:rounded-tl-[20rem] rounded-tr-[12rem] rounded-br-[24rem] rounded-bl-[6rem]" width='2048' height="2048" src="{{$post->heroUrl}}"
             srcset="{{$post->hero?->getSrcset('large')}}"
             alt="{{$post->hero->name}}" />

        <div class="-left-1 h-auto hidden lg:block absolute bottom-12">
            <div class="bg-black rounded-sm rounded-bl-[2rem] rounded-br-[5rem] lg:rounded-br-[0rem] ml-2 mix-blend-revert max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl">
                <div class="p-2 xl:px-4 pb-0">
                    <h1 class='font-bold text-2xl lg:text-4xl xl:text-5xl z-20 mb-0'>
                        @if($inArchive)
                            <a class="text-white" href="{{$post->link}}">
                                {{$post->title}}
                            </a>
                        @else
                            {{$post->title}}
                        @endif
                    </h1>
                </div>

                <div class="mb-4 px-2 xl:px-4">
                    <x-public.post-meta :post="$post" :badge="false" size="xs"></x-public.post-meta>
                </div>

                @if( !$inArchive && $post->categories->isNotEmpty() || $post->tags->isNotEmpty())
                <div class="px-4 flex flex-row gap-1 flex-wrap">
                    @if($post->categories->isNotEmpty())
                        @foreach($post->categories as $tax)
                            <x-public.post-taxonomies textColor="text-white" :tax="$tax"></x-public.post-taxonomies>
                        @endforeach
                    @endif
                    @if($post->tags->isNotEmpty())
                        @foreach($post->tags as $tax)
                            <x-public.post-taxonomies bgColor="bg-white" :tax="$tax"></x-public.post-taxonomies>
                        @endforeach
                    @endif
                </div>
                @endif

                <div class="">
                    <hr class="border-b border-white border-opacity-25 " />
                </div>

                <div class="p-4">
                    <x-public.post-audio :post="$post"></x-public.post-audio>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
