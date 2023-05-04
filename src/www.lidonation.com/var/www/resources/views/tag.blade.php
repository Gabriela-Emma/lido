<x-public-layout class="tag" :metaTitle="'Tag: ' . $tag->title">
    <x-public.page-header :size="'sm'">
        <x-slot name="title">
            <div class="block flex z-10 flex-col">
                <span class='z-10 font-semibold text-sm text-slate-700'>{{__('Tag') }}</span>
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
            @if ($tag->models->count() >= 6)
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
             @else
             <div class="flex flex-col gap-6 w-full">
                @if($tag->models?->isNotEmpty())
                    @foreach($tag->models as $post)
                        <hr class="border-b border-b-black"/>

                        <div class="flex flex-col lg:flex-row gap-4">
                            @if($post->hero)
                                <a class="block flex-shrink-0 w-96" href="{{$post->link}}">
                                    @include('post.drip-image')
                                </a>
                            @endif

                            <div class="flex flex-col gap-4">
                                @if( $post->categories->isNotEmpty() || $post->tags->isNotEmpty())
                                    <div class="flex flex-row flex-wrap gap-2 justify-start sm:max-w-md">
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

                                <h3 class="font-medium text-black text-xl line-clamp-1 2xl:text-3xl xl:line-clamp-2 p-0">
                                    <a href="{{$post->link}}">
                                        {{$post->title}}
                                    </a>
                                </h3>
                                @if($post->subtitle)
                                    <p class='text-lg xl:text-2xl subtitle relative font-medium'>
                                        {{ $post->subtitle }}
                                    </p>
                                @endif

                                <div class="-mt-2">
                                    <x-public.post-meta :post="$post"></x-public.post-meta>
                                </div>

                                <div
                                    class="text-sm md:text-lg text-gray-700 line-clamp-6 lg:line-clamp-3 2xl:line-clamp-4">
                                    @if($post->excerpt)
                                        <x-markdown>{{$post->excerpt}}</x-markdown>
                                    @else
                                        <x-markdown>{{Str::words($post->content, $post->hero ? 40 : 90)}}</x-markdown>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <hr class="border-b border-b-black"/>

                    <div class="flex flex-row justify-end text-sm">
                        <x-public.continue-reading text="{{$snippets->moreNews}}" theme="teal"
                                                   route='news'
                                                   style='button'></x-public.continue-reading>
                    </div>
                @endif
            </div>

            @endif

        </div>
    </section>

    <x-support-lido heading-leading='Support the' heading-span='Library'/>

</x-public-layout>
