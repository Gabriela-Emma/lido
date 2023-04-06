<x-public-layout class="home">
    <section class="bg-white pt-16 pb-8 relative mb-6">
        <div class="container">
            <x-markdown>{{$snippets->homeSnippetOne}}</x-markdown>
            <div class="max-w-6xl mt-2">
                <x-markdown>{{$snippets->homeSnippetTwo}}</x-markdown>
            </div>
        </div>
    </section>

    @if($newToLibrary)
        <section class="py-16 relative bg-primary-10 relative" id="new-to-library">
            <div class="container">
                <h2 class="text-5xl text-gray-900 decorate dark mb-6">
               <span class="">
                   {{$snippets->newToThe}}
               </span>
                    <span class="text-teal-600 opacity-90">
                  {{$snippets->library}}
               </span>
                </h2>
            </div>
            <div class="container">
                <div class="flex flex-nowrap gap-8 overflow-x-auto posts">
                    @if($latestLidoMinute)
                        <div class="flex flex-col shrink-0 snap-center w-[380px] lg:w-[420px] xl:w-[480px] 2xl:w-[540px]">
                                <?php $post = $latestLidoMinute; ?>
                            @include("podcast.drip")
                        </div>
                    @endif
                    <div class="flex-1 flex flex-col">
                        <div
                            class="flex flex-row flex-nowrap xl:gridxl:grid-cols-22xl:grid-cols-3 gap-6 posts">
                            @foreach($newToLibrary as $post)
                                <div
                                    class="w-[380px] xl:w[420px] 2xl:w-[420px] md:border-r md:border-gray-300 px-5 -mt-px -ml-px post">
                                        <?php $showHero = true; ?>
                                    @include("post.drip")
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{--    Getting Started--}}
    <section class="bg-white py-10 relative mb-8">
        <div class="container">
            <h2 class="text-5xl text-gray-900 decorate dark mb-6">
               <span class="">
                   {{$snippets->getting}}
               </span>
                <span class="text-teal-600 opacity-90">
                  {{$snippets->started}}
               </span>
            </h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex flex-row col-span-2 lg:col-span-1 lg:flex-col gap-4 lg:gap-8 h-full justify-between">
                    <div class="border-b border-gray-600 min-w-1/2">
                        <div class="bg-gray-900 mb-3">
                            <a href="{{localizeRoute('what-is-cardano')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://storage.googleapis.com/www.lidonation.com/340/responsive-images/what-is-cardano-future-boy___large_2048_2048.jpg"
                                     alt="What is Cardano"/>
                            </a>
                        </div>
                        <a href="{{localizeRoute('what-is-cardano')}}"
                           class="text-2xl 2xl:text-3xl block mb-4 text-gray-700">
                            {{$snippets->whatIsCardano}}
                        </a>
                    </div>
                    <div class="border-b border-gray-600 min-w-1/2">
                        <div class="bg-gray-900 mb-3">
                            <a href="{{localizeRoute('what-is-staking')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://storage.googleapis.com/www.lidonation.com/435/responsive-images/what-is-the-point-of-buying-ada-and-staking-in-cardano-hero-image___large_2048_2048.jpg"
                                     alt="What is Cardano">
                            </a>
                        </div>
                        <a href="{{localizeRoute('what-is-staking')}}"
                           class="text-2xl 2xl:text-3xl block mb-4 text-gray-700">
                            {{ $snippets->whatIsStaking }}
                        </a>
                    </div>
                </div>
                <div class="col-span-2 border-b border-gray-600">
                    <div class="bg-gray-900 mb-3">
                        <a href="//www.lidonation.com/posts/lido-nation-getting-in-the-middle-of-it">
                            <img class="filter hover:contrast-200"
                                 src="https://storage.googleapis.com/www.lidonation.com/535/responsive-images/Lido-Getting-In-The_Middle-Of-It___large_2048_2048.jpg"
                                 alt="What is Cardano">
                        </a>
                    </div>
                    <a href="//www.lidonation.com/posts/lido-nation-getting-in-the-middle-of-it"
                       class="text-2xl 2xl:text-3xl block mb-4 text-gray-700">
                        LIDO Nation - Getting in the middle of it
                    </a>
                </div>
                <div class="flex flex-row col-span-2 lg:col-span-1 lg:flex-col gap-4 lg:gap-8 h-full justify-between">
                    <div class="border-b border-gray-600">
                        <div class="bg-gray-900 mb-3">
                            <a href="{{localizeRoute('how-to-buy-ada')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://storage.googleapis.com/www.lidonation.com/432/responsive-images/how-to-buy-cardano-ada-hero-image___large_2048_2048.jpg"
                                     alt="How to buy ada">
                            </a>
                        </div>
                        <a href="{{localizeRoute('how-to-buy-ada')}}"
                           class="text-2xl 2xl:text-3xl block mb-4 text-gray-700">
                            {{ $snippets->howToBuyADA }}
                        </a>
                    </div>
                    <div class="border-b border-gray-600">
                        <div class="bg-gray-900 mb-3">
                            <a href="{{localizeRoute('how-to-stake-ada')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://storage.googleapis.com/www.lidonation.com/433/responsive-images/how-to-stake-your-ada-hero-image___large_2048_2048.jpg"
                                     alt="How to stake your ada">
                            </a>
                        </div>
                        <a href="{{localizeRoute('how-to-stake-ada')}}"
                           class="text-2xl 2xl:text-3xl block mb-4 text-gray-700">
                            {{ $snippets->howToStakeYourADA }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Insights & Reviews --}}
    <section class="bg-white py-10 relative mb-8">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 gap-6 lg:gap-10 xl:gap-16">
                <div class="col-span-2">
                    <div class="flex flex-col gap-6">
                        <div class="mb-6">
                            <h2 class="text-4xl lg:text-5xl text-gray-700 decorate dark">
                                <span class="flex flex-row items-end gap-2 flex-wrap">
                                    <span class="inline-flex flex-row gap-2">
                                       <span class="">
                                           {{$snippets->blockchain}}
                                       </span>
                                        <span class="text-teal-600 inline-block opacity-90">
                                           {{$snippets->headlines}}
                                       </span>
                                    </span>
                                    <span
                                        class="flex flex-row items-center gap-4 text-xs text-gray-700 xl:justify-end xl:text-sm xl:leading-8">
                                        <span>
                                            <span>
                                                {{now()->format('F d, Y')}}
                                            </span>
                                        </span>
                                        <span title="current price of ada according to Coin Market Cap">
                                            <span class="font-bold text-gray-400 2xl:inline-block">
                                                1₳ =
                                            </span>
                                                    <span>
                                                ${{ number_format($adaQuote?->price, 2, '.', '.') }}
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </h2>

                        </div>

                        <div class="flex flex-col gap-6">
                            @if($quickNews?->isNotEmpty())
                                @foreach($quickNews?->take(6) as $post)
                                    <div class="flex flex-row gap-4">
                                        @if($post->hero)
                                            <a class="block flex-shrink-0 w-40 sm:w-64" href="{{$post->link}}">
                                                @include('post.drip-image')
                                            </a>
                                        @endif
                                        <div class="flex flex-col gap-1 pt-4">
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

                                            <h3 class="font-medium text-lg sm:text-xl lg:text-3xl xl:text-4xl 2xl:text-5xl p-0">
                                                <a class="text-gray-700" href="{{$post->link}}">
                                                    {{$post->title}}
                                                </a>
                                            </h3>

                                            @if($post->subtitle)
                                                <p class='text-xl xl:text-2xl subtitle relative font-medium'>
                                                    {{ $post->subtitle }}
                                                </p>
                                            @endif

                                            <div class="py-2 mb-4">
                                                <x-public.post-meta :post="$post"></x-public.post-meta>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-b border-b-black"/>
                                @endforeach

                                <div class="flex justify-end text-sm flex-column">
                                    <x-public.continue-reading :text="$snippets->moreInsights" theme="teal"
                                                               route='insights'
                                                               style='button'></x-public.continue-reading>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3 mt-16 md:mt-0 bg-gray-100 md:bg-white">
                    <h2 class="text-3xl decorate dark xl:text-4xl text-gray-700">
                        <span class="inline-block p-4 md:p-0">
                            {{ $snippets->reviews }}
                        </span>
                    </h2>

                    <div class="space-y-6 p-4 md:p-0 lg:mt-8">
                        @foreach($reviews as $post)
                            <div class="lg:row-span-2 lg:col-span-2">
                                <div class="flex flex-col justify-start h-full article review">
                                    @if($post->hero)
                                        <div class="flex-shrink-0 mb-4 hidden md:inline-flex">
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
                                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 capitalize">
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

                                    <div class="py-1 mb-4">
                                        <span class="hidden md:w-5 md:h-5"></span>
                                        <x-public.stars :amount="$post?->ratings_average" :size="5"/>
                                    </div>

                                    <div
                                        class="text-base text-gray-500 overflow-x-hidden lg:line-clamp-4">
                                        <x-markdown>{{$post->summary}}</x-markdown>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LIDO Nation Community --}}
    <section class="bg-teal-600 py-16 relative">
        <div class="container">
            <h2 class="text-3xl text-gray-900 mb-6">
               <span class="text-white block opacity-90">
                   {{ $snippets->lIDONationCommunity }}
               </span>
            </h2>
            <div class="gridgrid-cols-5gap-6">
                <div class="flex flex-row gap-6 justify-start text-white w-full overflow-x-auto">
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-accent-900 w-44 xl:w-80h-40xl:w-80xl:h-48">
                            <a class="block" href="{{localizeRoute('lido-pool')}}">
                                <img
                                    class="responsive w-full h-28 object-cover object-top rounded-sm bg-teal-600 filter hover:contrast-200"
                                    src="{{$pages?->pool?->hero?->getUrl('thumbnail')}}"
                                    alt="{{$pages?->pool?->hero->name}}"/>
                            </a>
                        </div>
                        <h3 class="text-2xl mb-4">
                            <a class="text-white block hover:text-yellow-500" href="{{localizeRoute('lido-pool')}}">
                                {{$pages?->pool?->title}}
                            </a>
                        </h3>
                    </div>
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-teal-900 p-4 w-44 flex justify-center items-center">
                            <a href="{{localizeRoute('phuffycoin')}}"
                               class="relative inline-block rounded-full -top-2 mx-auto w-24 h-20  filter hover:contrast-200">
                                @include('svg.phuffycoin-logo')
                            </a>
                        </div>
                        <h3 class="text-2xl mb-4">
                            <a class="text-white block hover:text-yellow-500" href="{{localizeRoute('phuffycoin')}}">
                                {{ $snippets->learnAboutPhuffycoin }}
                            </a>
                        </h3>
                    </div>
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-phuffy2-700 w-44 xl:w-80h-40xl:w-80xl:h-48">
                            <a class="block" href="{{localizeRoute('financial-details')}}">
                                <img
                                    class="responsive w-full h-28 object-cover object-top rounded-sm bg-teal-600 filter hover:contrast-200"
                                    src="//storage.googleapis.com/www.lidonation.com/317/lido-finantial-details-kenny-eliason-unsplash.jpg"
                                    alt="{{$pages?->pool?->hero->name}}"/>
                            </a>

                        </div>
                        <h3 class="text-2xl mb-4">
                            <a class="text-white block hover:text-yellow-500"
                               href="{{localizeRoute('financial-details')}}">
                                {{ $snippets->financialDetails }}
                            </a>
                        </h3>
                    </div>
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-white w-44 xl:w-80h-40xl:w-80xl:h-48">
                            <a class="block" href="{{localizeRoute('contributeContent')}}">
                                <img
                                    class="responsive w-full h-28 object-cover object-top rounded-sm bg-teal-600 filter hover:contrast-200"
                                    src="//storage.googleapis.com/www.lidonation.com/318/lidonation-idea-junior-ferreira-unsplash.jpg"
                                    alt="{{$pages?->pool?->hero->name}}"/>
                            </a>
                        </div>
                        <h3 class="text-2xl mb-4">
                            <a class="text-white block hover:text-yellow-500"
                               href="{{localizeRoute('contributeContent')}}">
                                {{$snippets->contributeContent}}
                            </a>
                        </h3>
                    </div>

                    <div class="inline-flex ml-auto w-80 relative">
                        <div class="absolute w-full h-full bg-teal-600 bg-opacity-75"></div>
                        <div class="w-[20rem] text-white">
                            @include('svg.lido-logo')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--    Project Catalyst --}}
    <section class="bg-white py-16 relative">
        <div class="container">
            <h2 class="text-5xl text-gray-700 mb-6">
               <span class="">
                   {{ $snippets->explore }}
               </span>
                <span class="text-teal-600 block opacity-90">
                   {{ $snippets->catalystExplorer }}
               </span>
            </h2>
            <div class="grid grid-cols-5 gap-6 w-full overflow-x-auto">
                <div class="flex flex-row gap-6 flex-nowrap">
                    <div class="border border-gray-600 rounded-sm">
                        <div class="bg-white px-2 py-4 border-b border-gray-600 sm:px-6 w-[20rem]">
                            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                                <div class="ml-4 mt-2">
                                    <h3 class="text-lg leading-6 font-medium text-gray-800 flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-lg font-semibold">
                                            {{ $snippets->importantDates }}
                                        </span>
                                    </h3>
                                </div>
                                <div class="ml-4 mt-2 flex-shrink-0">
                                    <button type="button"
                                            class="inline-flex items-center px-2 py-1 border border-gray-600 shadow-xs text-xs font-medium rounded-sm text-gray-700 hover:text-white bg-white hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                        {{ $snippets->viewCalendar }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <ul role="list" class="divide-y divide-gray-700">
                            @foreach($events as $event)
                                <li class="p-3 flex gap-2">
                                    <div
                                        class="h-10 w-10 flex flex-shrink-0 rounded-full bg-teal-600 flex items-center justify-center bold text-white">
                                        {{$event->starts_at->format('d')}}
                                    </div>
                                    <div class="flex-shrink-1">
                                        <p x-data="{ tooltip: @js($event->name) }"
                                           class="text-md font-medium text-gray-900 line-clamp-1">
                                            <span x-tooltip.theme.primary="tooltip">
                                                {{$event->name}}
                                            </span>
                                        </p>
                                        <div class="text-gray-800 flex flex-row justify-between gap-1 text-xs">
                                            <div>
                                                <span class="text-gray-500 italic block">
                                                    Starts (UTC):
                                                </span>
                                                <span class="font-semibold">
                                                    {{$event->starts_at->format('M d h:i A')}}
                                                </span>
                                            </div>
                                            @if($event->ends_at)
                                                <div>
                                                    <span class="text-gray-500 block">
                                                        Ends (UTC):
                                                    </span>
                                                    <span class="font-semibold">
                                                        {{$event->ends_at->format('M d h:i A')}}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bg-teal-600 text-white inline-col justify-start items-start min-w-[20rem]">
                        <div
                            class="flex items-center p-4 justify-between items-center flex-wrap sm:flex-nowrap w-[20rem]">
                            <div>
                                <h3 class="text-xl leading-6 font-semibold flex gap-1 items-center">
                                    <span>
                                        {{ $snippets->catalystNumbers }}
                                    </span>
                                </h3>
                            </div>
                            <div class="ml-4mt-2 flex-shrink-0">
                                <a href="{{localizeRoute('projectCatalyst.dashboard')}}" type="button"
                                   class="inline-flex items-center px-2 py-1 border border-white text-xs font-medium rounded-sm text-white hover:text-white bg-transparent hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                    {{ $snippets->analytics }}
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap">
                            <hr class="border-b border-white w-full my-0"/>
                            <div class="p-4">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-2xl inline-block font-semibold">
                                            ${{humanNumber($stats->completedProposals)}}
                                        </div>
                                        <div class="text-xs inline-block text-center">
                                            {{ $snippets->completedProjects }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-4xl inline-block font-semibold">
                                            {{humanNumber($stats->numberOfBuilders)}}
                                        </div>
                                        <div class="text-sm inline-block text-center">
                                            Builders in Catalyst
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-4xl inline-block font-semibold">
                                            {{humanNumber($stats->proposalsCount)}}
                                        </div>
                                        <div class="text-xs inline-block text-center">
                                            Number of Funded Projects
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-3xl inline-block font-semibold">
                                            ${{humanNumber($stats->avgFundedProposals)}}
                                        </div>
                                        <div class="text-xs inline-block text-center">
                                            Average Funded Amount
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($catalystArticle)
                        <div class="bg-gray-50 border border-gray-600 rounded-sm min-w-[19rem] relative">
                            <div
                                class="absolute top-0 w-full p-4 flex items-center justify-end flex-wrap sm:flex-nowrap z-20">
                                <a href="{{$catalystArticle->link}}" type="button"
                                   class="inline-flex items-center px-2.5 py-1.5 border border-white text-xs font-medium rounded-sm text-white hover:text-gray-100 bg-teal-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                    View Article
                                </a>
                            </div>
                            <div class="absolute bottom-0 w-full p-2 pb-4">
                                <p class="bg-teal-600 inline tracking-wider leading-9 shadow-xs box-border font-semibold box-decoration-clone p-2 text-2xl">
                                    <a class="text-white hover:text-yellow-500 pg-16" href="{{$catalystArticle->link}}">
                                        {{$catalystArticle->title}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif
                    @if($proposal)
                        <div
                            class="rounded-sm bg-gradient-to-br from-teal-800 via-teal-600 to-accent-900 min-w-[28rem] text-white relative">
                            <div class="bg-transparent p-4 px-6 absolute right-0 flex flex-row justify-end z-30">
                                <a href="{{localizeRoute('projectCatalyst.projects')}}" type="button"
                                   class="inline-flex items-center px-2 py-1 border border-white text-xs font-semibold rounded-sm text-white hover:text-white bg-teal-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                    Explore Proposals
                                </a>
                            </div>
                            <div class="p-4 z-10 relative opacity-50 pointer-events-none">
                                <div class="flex flex-row gap-4 justify-between flex-no-wrap">
                                    <h2 class="font-semibold max-w-[70%]">
                                        <a href="{{url('proposals/' . $proposal->slug)}}">
                                        <span class="text-white hover:text-yellow-500">
                                            {{$proposal->title}}
                                        </span>
                                        </a>
                                    </h2>
                                </div>
                                <div class="2xl:h[80px]">
                                    <div class="flex flex-row flex-no-wrap  mb-2">
                                        @if($proposal->amount_received > 0.00)
                                            <div
                                                class="inline-block px-2 py-0.5 pb-3 text-sm font-semibold rounded-tl-sm rounded-bl-sm bg-pink-600">
                                                ${{ number_format($proposal->amount_received, 2, '.', ',') }}
                                                <sub class="text-gray-200 block mt-0.5 italic">
                                                    Received
                                                </sub>
                                            </div>
                                        @endif
                                        <div
                                            class="inline-block px-2 py-0.5 pb-3 text-sm font-semibold rounded-tr-sm rounded-br-2m bg-accent-700">
                                            ${{ number_format($proposal->amount_requested, 2, '.', ',') }}
                                            <sub class="text-gray-200 block mt-0.5 italic">
                                                Requested
                                            </sub>
                                        </div>
                                    </div>

                                    <div>
                                        <b class="text-sm">Solution:</b>
                                        <x-markdown>{{$proposal->solution}}</x-markdown>
                                    </div>

                                    <div class="flex flex-col gap-2 my-4 text-sm">
                                        @if($proposal->amount_requested &&  $proposal->fund->amount)
                                            <div class="space-x-1 italic">
                                                @if(!$proposal->funding_status == 'completed')
                                                    <span
                                                        class="inline-block px-1.5 py-0.5 font-semibold text-white text-sm rounded-sm bg-pink-400">
                                                    completed
                                                </span>
                                                @endif
                                                <span class="text-accent-300">
                                            {{$proposal->funded_at ? 'Awarded' : 'Requested'}} {{$proposal->amount_requested ==  $proposal->amount_received ? '& Received' : ''}} {{round((float)($proposal->amount_requested / $proposal->fund->amount) * 100, 3 ) . '%'}} of the
                                            fund.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="divide-y divide-teal-200">
                                    <div
                                        class="flex flex-row gap-1 justify-start items-center py-1 border-t border-teal-200">
                                        <a class="font-normal text-white hover:text-white" href="#discussions">
                                            <livewire:ratings.model-average-rating-component
                                                :modelId="$proposal->id"
                                                wire:key="{{$proposal->id}}"
                                                :modelType="\App\Models\Proposal::class"/>
                                        </a>
                                    </div>
                                    <div
                                        class="flex grid flex-row grid-cols-2 justify-start items-center py-2 space-x2 text-sm">
                                        <div class="flex flex-row gap-2">
                                            <div class="font-medium text-gray-300">
                                                Yes Votes:
                                            </div>
                                            <div>
                                                {{$proposal->yes_votes_count_formatted}}
                                            </div>
                                        </div>
                                        <div class="flex flex-row gap-2">
                                            <div class="font-medium text-gray-300">
                                                No Votes:
                                            </div>
                                            <div>
                                                {{$proposal->no_votes_count_formatted}}
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-0 border-teal-200"/>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Headlines --}}
    <section class="py-16 relative bg-primary-10 relative">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-8 gap-8 xl:gap-16">
                <div class="lg:col-span-6">
                    <h2 class="text-4xl lg:text-5xl text-gray-700 decoratedarkmb-6">
                         <span class="">
                           {{ $snippets->blockchain }}
                       </span>
                        <span class="text-teal-600 inline-block opacity-90">
                           {{ $snippets->insights }}
                       </span>
                    </h2>
                    <div class="flex flex-col gap-6">
                        @if($insights?->isNotEmpty())
                            @foreach($insights as $post)
                                <hr class="border-b border-b-black"/>

                                <div class="flex flex-col lg:flex-row-reverse gap-4">
                                    @if($post->hero)
                                        <a class="block flex-shrink-0 w-72" href="{{$post->link}}">
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
                </div>
                <div class="lg:col-span-2">
                    <div class="flex flex-col gap-6 w-full sticky top-10">
                        <h2 class="text-3xl text-gray-600">
                            Contributors
                        </h2>
                        <div class="gap-6 flex flex-col">
                            @foreach($users as $user)
                                @if($user->hasAllRoles(['super admin', 'editor']))
                                    <x-public.widgets.author :author="$user"/>
                                @endif
                            @endforeach


                            <x-public.widgets.newsletter bg="bg-yellow-500" classes="text-yellow-900" layout="col"/>

                            <x-public.widgets.meetup :meetups="$meetups" :dayOfWeek="$dayOfWeek"
                                                     :hourOfDay="$hourOfDay"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
