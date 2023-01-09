<x-public-layout class="tag" :metaTitle="'Tag: ' . $tag->title">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <div class="block flex z-10 flex-col gap-2 sm:flex-row">
                <span class='z-10 font-semibold'>{{__('Tag:') }}</span>
                <span class='z-10 font-semibold text-teal-600'>{{ $tag->title  }}</span>
            </div>
            <p class="mt-3 mb-1 text-xl max-w-3xl font-normal text-gray-500 sm:mt-4">
                {{$tag->content}}
            </p>
        </x-slot>
    </x-public.page-header>

    <section class="relative bg-pool-bw-light bg-cover bg-center bg-scroll bg-gray-50 bg-blend-hard-light"
             aria-labelledby="quick-links-title">
        <hr />
        <div class="container py-8">
            <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 mt-8">
                @foreach($tag->models as $post)
                    @if($loop->first)
                        @include("post.highlight")
                        <div class="col-span-2 xl:col-span-3 2xl:col-span-4 my-4"></div>
                    @else
                        <div class="p-8 border border-gray-300 -mt-px -ml-px">
                            <?php $showHero = true; ?>
                            @include("post.drip")
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
