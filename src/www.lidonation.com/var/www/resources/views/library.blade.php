<x-public-layout class="library" metaTitle="LIDO Nation Library">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <div class="z-10 flex flex-col block gap-3 sm:flex-row">
                <span class='z-10 font-light'>{{__('LIDO Nation') }}</span>
                <span class='z-10 font-black text-teal-600'>{{__('Library') }}</span>
            </div>
            <p class="mt-3 mb-1 text-xl font-normal text-gray-500 sm:mt-4">
                {{$snippets->headlinesInsightsReviews}}
            </p>
        </x-slot>
        <div>
            <ul class="grid grid-cols-3 text-base text-center">
                <li class="-mt-px -ml-px border border-gray-300">
                    <a href="#news-section"
                        class="inline-block p-3 font-normal text-gray-600 hover:text-teal-600">
                        {{$snippets->news}}
                    </a>
                </li>
                <li class="-mt-px -ml-px border border-gray-300">
                    <a href="#insights-section"
                        class="inline-block p-3 font-normal text-gray-600 hover:text-teal-600">
                        {{$snippets->insights}}
                    </a>
                </li>
                <li class="-mt-px -ml-px border border-gray-300">
                    <a href="#reviews-section"
                        class="inline-block p-3 font-normal text-gray-600 hover:text-teal-600">
                        {{$snippets->reviews}}
                    </a>
                </li>
            </ul>
        </div>
    </x-public.page-header>

    @if($quickNews?->isNotEmpty())
        <section class="relative bg-white relatives" id="news-section">
            <hr />
            <div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-24">
                <div class="flex flex-col gap-y-8 lg:grid lg:grid-cols-8 xl:grid-cols-5 xl:gap-12 lg:gap-8">
                    <div class="hidden lg:block lg:col-span-5 xl:col-span-3">
                        @foreach($quickNews->take(1) as $article)
                            @include("post.cover")
                        @endforeach
                    </div>
                    <div class="col-span-3 xl:col-span-2">
                        <div class="flex flex-col xl:flex-row xl:justify-between xl:items-end">
                            <h2 class="text-3xl font-extrabold text-pink-500 lg:text-2xl">
                                {{$snippets->cardanoCryptoNews}}
                            </h2>
                            <div>
                                <div
                                    class="flex flex-row items-end gap-4 text-xs leading-7 text-gray-700 xl:justify-end xl:text-sm xl:leading-7">
                                    <div>
                                        <span>
                                            {{now()->format('F d, Y')}}
                                        </span>
                                    </div>
                                    <div title="current price of ada according to Coin Market Cap">
                                    <span class="font-bold text-gray-300 2xl:inline-block">
                                        1₳ =
                                    </span>
                                        <span>
                                        ${{ number_format($adaQuote?->price, 2, '.', '.') }}
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <hr class="border-b border-gray-100"/>
                        </div>
                        <div class="flex flex-col">
                            <div class="lg:max-h-[32rem] xl:max-h-[100rem] overflow-y-auto">
                                @foreach($quickNews->take(4) as $post)
                                    @once
                                        <?php $direction = 'flex-row-reverse'; ?>
                                    @endonce
                                    <div class="{{$loop->first ? 'lg:hidden' : ''}}">
                                        @include('post.mini')
                                    </div>

                                    <hr class="{{$loop->first ? 'lg:hidden' : ''}}"/>
                                @endforeach
                            </div>
                            <div class="flex flex-row justify-center mt-4 text-sm">
                                <x-public.continue-reading text="{{$snippets->moreNews}}" theme="primary"
                                route='news'
                                style='button'></x-public.continue-reading>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="relative bg-gray-50">
        <div class="container px-4 py-12 mx-auto text-center sm:px-6 lg:px-8 lg:py-20">
            <h2 class="mb-4 text-2xl font-extrabold text-teal-600 xl:text-4xl 2xl:text-6xl">
            {{$snippets->newToCardano}}
            </h2>
            <p>
            {{$snippets->resourcesToGetYouStarted}}
            </p>
            <div>
                <ul class="grid items-end justify-center grid-cols-2 gap-20 mt-12 lg:grid-cols-4 xl:text-xl 3xl:text-2xl">
                    <li class="flow-root">
                        <a href="{{route('what-is-cardano')}}"
                            class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.cardano')
                            </div>
                            <span>
                                {{$snippets->whatIsCardano}}
                            </span>
                        </a>
                    </li>

                    <li class="flow-root">
                        <a href="{{route('what-is-staking')}}"
                            class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.pool-network')
                            </div>
                            <span>
                                {{$snippets->whatIsStaking}}
                            </span>
                        </a>
                    </li>

                    <li class="flow-root">
                        <a href="{{route('how-to-buy-ada')}}"
                            class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.crypto-bank')
                            </div>
                            <span>
                                {{$snippets->howToBuyADA}}
                            </span>
                        </a>
                    </li>

                    <li class="flow-root">
                        <a href="{{route('how-to-stake-ada')}}"
                            class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.funfair')
                            </div>
                            <span>
                                {{$snippets->howToStakeYourADA}}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    @if($insights?->isNotEmpty())
        <section class="relative" id="insights-section">
            <div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-24">
                <div class="flex flex-col gap-8 lg:grid lg:grid-cols-8">
                    <div class="col-span-6 mb-8 lg:mb-0">
                        <div class="flex flex-row items-center gap-2">
                            <h2 class="pt-0 mt-0 mb-2 text-3xl font-extrabold text-pink-500 xl:text-4xl 2xl:text-3xl">
                                {{$snippets->insights}}
                            </h2>

                            <div class="relative text-sm -top-1">
                                <x-public.continue-reading :text="$snippets?->moreInsights" route='insights' />
                            </div>

                        </div>
                        <p class="mb-8 text-2xl text-gray-500">
                            {{$snippets->deepDiveIntoWorldOfBlockchain}}
                        </p>

                        <div class="md:grid md:grid-cols-3">
                            @foreach($insights->take(8) as $post)
                                <div class="p-8 -mt-px -ml-px border border-gray-300">
                                    <?php $showHero = true; ?>
                                    @include('post.drip')
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-4 text-sm flex-column">
                            <x-public.continue-reading :text="$snippets->moreInsights" theme="primary"
                                route='insights'
                                style='button'></x-public.continue-reading>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-span-2">
                        <div
                            class="grid grid-cols-1 gap-8 lg:sticky lg:top-8 sm:grid-cols-2 lg:grid-initial lg:flex lg:flex-col">
                            <x-public.widgets.newsletter/>
                            {{-- <a href="//meetup.com/lido-nation-cardano-pool-meetup/" target="_blank"> --}}

                            {{-- <x-public.widgets.meetup :meetups="$meetups" :dayOfWeek="$dayOfWeek" --}}
                                {{-- :hourOfDay="$hourOfDay"/> --}}
                            {{-- </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    @if($reviews?->isNotEmpty())
        <section class="relative bg-gray-50 reviews" id="reviews-section">
            <div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-24">
                <h2 class="pt-0 mt-0 mb-2 text-3xl font-extrabold text-pink-500 xl:text-4xl 2xl:text-3xl">
                    {{$snippets->reviews}}
                </h2>
                <p class="mb-8 text-2xl text-gray-500">
                    {{$snippets->promisingConsumerFacingProjectsInTheCardanoEcosystem}}
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
                                        <h3 class="text-2xl font-semibold text-gray-900 capitalize">
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
    @endif

    <x-support-lido heading-leading='Support the' heading-span='Library'/>
</x-public-layout>

