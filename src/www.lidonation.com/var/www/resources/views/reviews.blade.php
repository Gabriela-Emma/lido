<x-public-layout class="news" title="Cardano and Crypto News">
    <header>
        <div class="container py-4">
            <div class="pb-4">
                <div class="flex flex-row gap-4 text-sm">
                    <div>
                        <span class="font-bold text-gray-300">
                            Today
                        </span>
                        <span>
                        {{now()->format('F d')}}
                        </span>
                    </div>
                    @if($adaQuote)
                        <div title="current price of ada according to Coin Market Cap">
                        <span class="font-bold text-gray-300">
                            1 ₳ =
                        </span>
                            <span>
                            ${{ number_format($adaQuote?->price, 2, '.', '.') }}
                        </span>
                        </div>
                    @endif
                </div>
                <div>

                </div>
            </div>
            <hr class="border-gray-300"/>
            <div>
                <h1 class="py-8 text-3xl font-extrabold md:text-5xl lg:text-6xl 2xl:text-8xl lg:py-12 2xl:py-8">
                    Reviews
                </h1>
            </div>
            <hr class="border-gray-300"/>
        </div>
    </header>
    <section class="relative bg-gray-50 reviews">
        <div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-24">
            <h2 class="pt-0 mt-0 mb-2 text-3xl font-extrabold text-pink-500 xl:text-4xl 2xl:text-3xl">
                {{ $snippets->reviews }}
            </h2>
            <p class="mb-8 text-2xl text-gray-500">
                {{ $snippets->promisingConsumerFacingProjectsInTheCardanoEcosystem }}
            </p>

            <div class="">
                @foreach($reviews->take(9)->chunk(3) as $group)
                    <div class="grid grid-cols-2 gap-8 mb-8 lg:grid-cols-5 lg:grid-rows-4"
                         style="{{$loop->even ? 'direction:rtl;' : ''}}">
                        @foreach($group as $post)
                            <div
                                style="direction: initial"
                                class="{{$loop->first ? 'lg:row-span-4 col-span-2 lg:col-span-3' : 'lg:row-span-2 lg:col-span-2'}}">
                                <div
                                    class="flex flex-col justify-start h-full article review">
                                    @if($post->hero)
                                        <div class="flex-shrink-0 mb-4">
                                            <a href="{{$post->link}}">
                                                @if($loop->first)
                                                    <img
                                                        class="object-cover w-full filter bg-teal-600 hover:contrast-200"
                                                        srcset="{{$post->hero?->getSrcset('large')}}"
                                                        src="{{$post->hero?->getUrl('large')}}"
                                                        alt="{{$post->hero?->name}}"/>
                                                @else
                                                    <img
                                                        class="object-cover w-full filter bg-teal-600 hover:contrast-200"
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
                                    <h3 class="text-2xl font-semibold text-gray-900 capitalize">
                                        <a href="{{$post->link}}"
                                           class="space-x-1 hover:text-teal-600 line-clamp-4 lg:line-clamp-2">
                                                <span>
                                                    {{$post->title}}
                                                </span>
                                            <span class="capitalize">
                                                {{ $snippets->review }}
                                                </span>
                                        </a>
                                    </h3>

                                    @if(!$loop->first)
                                        <div class="py-1 mb-4">
                                            <span class="hidden md:w-5 md:h-5"></span>
                                            <x-public.stars :amount="$post?->ratings_average" :size="5"/>
                                        </div>
                                    @endif

                                    <div
                                        class="text-base text-gray-500 overflow-x-hidden {{!$loop->first ? 'lg:line-clamp-4' : 'lg:line-clamp-9'}}">
                                        <x-markdown>{{$post->summary}}</x-markdown>
                                    </div>
                                    <div>
                                        @if($loop->first)
                                            <div>
                                                <x-public.review-rating-summary
                                                    :review="$post"></x-public.review-rating-summary>
                                            </div>
                                        @endif
                                    </div>
                                    @if($loop->first)
                                        <div class="mt-4 text-sm capitalize">
                                            <x-public.continue-reading
                                                :link="$post->url"
                                                :text="$snippets->readFullReview"></x-public.continue-reading>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-support-lido heading-leading='Support the' heading-span='Library'/>

</x-public-layout>
