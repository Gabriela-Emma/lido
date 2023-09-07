<x-public-layout class="home">
    <section class="relative pt-16 pb-8 mb-6 bg-white">
        <div class="container">
            <x-markdown>{{$snippets->homeSnippetOne}}</x-markdown>
            <div class="max-w-6xl mt-2">
                <x-markdown>{{$snippets->homeSnippetTwo}}</x-markdown>
            </div>
        </div>
    </section>

    @if($quickPitches && $quickPitches->count() > 0)
    <section>
        <div class="relative py-8 overflow-hidden bg-yellow-500">
            <div class="pt-16 pb-80 sm:pb-40 sm:pt-24 lg:pb-48 lg:pt-40">
                <div class="container relative px-4 sm:static sm:px-6 lg:px-8">
                    <div class="bg-yellow-500 sm:max-w-md">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                            Project Catalyst Fund10 is Live!
                        </h1>
                        <p class="mt-4 text-xl text-gray-700">
                            Voting for Fund 10 kicks off on <span class="font-bold">August 31st</span>. There are lots of great proposals to checkout! Here are some quickpitches to get you started.
                        </p>
                    </div>
                    <div>
                        <div class="mt-10">
                            <!-- Decorative image grid -->
                            <div aria-hidden="true" class="z-0 lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
                                <div class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
                                    <div class="flex items-center space-x-6 lg:space-x-8">
                                    <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                        @foreach($quickPitches->take(2) as $quickpitch)
                                        <div class="w-64 h-48 p-1 overflow-hidden rounded-sm bg-slate-900" x-data="quickpitch">
                                            <div
                                                class="w-full rounded-md quick-pitch-video"
                                                id="quick-pitch-{{$quickpitch->id}}"
                                                x-ref="quickPitch"
                                                data-plyr-provider="youtube"
                                                data-plyr-embed-id="{{$quickpitch->quick_pitch_id}}"></div>

                                                <a href="{{$quickpitch->link}}" class="block p-2 text-base text-yellow-600 hover:text-yellow-800">
                                                    <div class="text-xs text-slate-200">View Proposal</div>
                                                    {{$quickpitch->title}}
                                                </a>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                        @foreach($quickPitches->skip(2)->take(3) as $quickpitch)
                                            @if($loop->iteration == 2)
                                                <div class="p-1 mx-auto overflow-hidden rounded-sm h-52 w-72 bg-slate-900" x-data="quickpitch">
                                                    <div
                                                        class="w-full quick-pitch-video"
                                                        id="quick-pitch-{{$quickpitch->id}}"
                                                        x-ref="quickPitch"
                                                        data-plyr-provider="youtube"
                                                        data-plyr-embed-id="{{$quickpitch->quick_pitch_id}}"></div>

                                                        <a href="{{$quickpitch->link}}" class="block p-2 text-base text-yellow-600 hover:text-yellow-800">
                                                            <div class="text-xs text-slate-200">View Proposal</div>
                                                            {{$quickpitch->title}}
                                                        </a>
                                                </div>
                                            @else
                                                <div class="w-64 h-48 p-1 mx-auto overflow-hidden rounded-sm bg-slate-900" x-data="quickpitch">
                                                    <div
                                                        class="w-full quick-pitch-video"
                                                        id="quick-pitch-{{$quickpitch->id}}"
                                                        x-ref="quickPitch"
                                                        data-plyr-provider="youtube"
                                                        data-plyr-embed-id="{{$quickpitch->quick_pitch_id}}"></div>

                                                        <a href="{{$quickpitch->link}}" class="block p-2 text-base text-yellow-600 hover:text-yellow-800">
                                                            <div class="text-xs text-slate-200">View Proposal</div>
                                                            {{$quickpitch->title}}
                                                        </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                        @foreach($quickPitches->skip(5)->take(2) as $quickpitch)
                                        <div class="w-64 h-48 p-1 overflow-hidden rounded-sm bg-slate-900" x-data="quickpitch">
                                            <div
                                                class="w-full quick-pitch-video"
                                                id="quick-pitch-{{$quickpitch->id}}"
                                                x-ref="quickPitch"
                                                data-plyr-provider="youtube"
                                                data-plyr-embed-id="{{$quickpitch->quick_pitch_id}}"></div>

                                                <a href="{{$quickpitch->link}}" class="block p-2 text-base text-yellow-600 hover:text-yellow-800">
                                                    <div class="text-xs text-slate-200">View Proposal</div>
                                                    {{$quickpitch->title}}
                                                </a>
                                        </div>
                                        @endforeach
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <a href="https://www.lidonation.com/en/catalyst-explorer/proposals?l=24&qp=&fs[]=113&t=p&st=ranking_total%3Adesc"
                            class="relative z-20 inline-block px-8 py-3 font-medium text-center text-yellow-500 bg-black border border-transparent rounded-sm hover:text-white">
                                View more quickpitches
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($newToLibrary)
        <section class="relative py-16 bg-primary-10" id="new-to-library">
            <div class="container">
                <h2 class="mb-6 text-5xl text-gray-900 decorate dark">
               <span class="">
                   {{$snippets->newToThe}}
               </span>
                    <span class="text-teal-600 opacity-90">
                  {{$snippets->library}}
               </span>
                </h2>
            </div>
            <div class="container">
                <div class="flex gap-8 overflow-x-auto flex-nowrap posts">
                    @if($latestLidoMinute)
                        <div class="flex flex-col shrink-0 snap-center w-[380px] lg:w-[420px] xl:w-[480px] 2xl:w-[540px]">
                                <?php $post = $latestLidoMinute; ?>
                            @include("podcast.drip")
                        </div>
                    @endif
                    <div class="flex flex-col flex-1">
                        <div
                            class="flex flex-row gap-6 flex-nowrap xl:gridxl:grid-cols-22xl:grid-cols-3 posts">
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
    <section class="relative py-10 mb-8 bg-white">
        <div class="container">
            <h2 class="mb-6 text-5xl text-gray-900 decorate dark">
               <span class="">
                   {{$snippets->getting}}
               </span>
                <span class="text-teal-600 opacity-90">
                  {{$snippets->started}}
               </span>
            </h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="flex flex-row justify-between h-full col-span-2 gap-4 lg:col-span-1 lg:flex-col lg:gap-8">
                    <div class="border-b border-gray-600 min-w-1/2">
                        <div class="mb-3 bg-gray-900">
                            <a href="{{localizeRoute('what-is-cardano')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://www.lidonation.com/storage/340/responsive-images/what-is-cardano-future-boy___large_2048_2048.jpg"
                                     alt="What is Cardano"/>
                            </a>
                        </div>
                        <a href="{{localizeRoute('what-is-cardano')}}"
                           class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                            {{$snippets->whatIsCardano}}
                        </a>
                    </div>
                    <div class="border-b border-gray-600 min-w-1/2">
                        <div class="mb-3 bg-gray-900">
                            <a href="{{localizeRoute('what-is-staking')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://www.lidonation.com/storage/435/responsive-images/what-is-the-point-of-buying-ada-and-staking-in-cardano-hero-image___large_2048_2048.jpg"
                                     alt="What is Cardano">
                            </a>
                        </div>
                        <a href="{{localizeRoute('what-is-staking')}}"
                           class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                            {{ $snippets->whatIsStaking }}
                        </a>
                    </div>
                </div>
                <div class="col-span-2 border-b border-gray-600">
                    <div class="mb-3 bg-gray-900">
                        <a href="//www.lidonation.com/posts/lido-nation-getting-in-the-middle-of-it">
                            <img class="filter hover:contrast-200"
                                 src="https://www.lidonation.com/storage/535/responsive-images/Lido-Getting-In-The_Middle-Of-It___large_2048_2048.jpg"
                                 alt="What is Cardano">
                        </a>
                    </div>
                    <a href="//www.lidonation.com/posts/lido-nation-getting-in-the-middle-of-it"
                       class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                        LIDO Nation - Getting in the middle of it
                    </a>
                </div>
                <div class="flex flex-row justify-between h-full col-span-2 gap-4 lg:col-span-1 lg:flex-col lg:gap-8">
                    <div class="border-b border-gray-600">
                        <div class="mb-3 bg-gray-900">
                            <a href="{{localizeRoute('how-to-buy-ada')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://www.lidonation.com/storage/432/responsive-images/how-to-buy-cardano-ada-hero-image___large_2048_2048.jpg"
                                     alt="How to buy ada">
                            </a>
                        </div>
                        <a href="{{localizeRoute('how-to-buy-ada')}}"
                           class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                            {{ $snippets->howToBuyADA }}
                        </a>
                    </div>
                    <div class="border-b border-gray-600">
                        <div class="mb-3 bg-gray-900">
                            <a href="{{localizeRoute('how-to-stake-ada')}}">
                                <img class="filter hover:contrast-200"
                                     src="https://www.lidonation.com/storage/433/responsive-images/how-to-stake-your-ada-hero-image___large_2048_2048.jpg"
                                     alt="How to stake your ada">
                            </a>
                        </div>
                        <a href="{{localizeRoute('how-to-stake-ada')}}"
                           class="block mb-4 text-2xl text-gray-700 2xl:text-3xl">
                            {{ $snippets->howToStakeYourADA }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Insights & Reviews --}}
    <section class="relative py-10 mb-8 bg-white">
        <div class="container">
            <div class="gap-6 lg:grid lg:grid-cols-3 lg:gap-10 xl:gap-16">
                <div class="col-span-2">
                    <div class="flex flex-col gap-6">
                        <div class="mb-6">
                            <h2 class="text-4xl text-gray-700 lg:text-5xl decorate dark">
                                <span class="flex flex-row flex-wrap items-end gap-2">
                                    <span class="inline-flex flex-row gap-2">
                                       <span class="">
                                           {{$snippets->blockchain}}
                                       </span>
                                        <span class="inline-block text-teal-600 opacity-90">
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
                                            <a class="flex-shrink-0 block w-40 sm:w-64" href="{{$post->link}}">
                                                @include('post.drip-image')
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
                                                <a class="text-gray-700" href="{{$post->link}}">
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
                <div class="flex flex-col gap-3 mt-16 bg-gray-100 md:mt-0 md:bg-white">
                    <h2 class="text-3xl text-gray-700 decorate dark xl:text-4xl">
                        <span class="inline-block p-4 md:p-0">
                            {{ $snippets->reviews }}
                        </span>
                    </h2>

                    <div class="p-4 space-y-6 md:p-0 lg:mt-8">
                        @foreach($reviews as $post)
                            <div class="lg:row-span-2 lg:col-span-2">
                                <div class="flex flex-col justify-start h-full article review">
                                    @if($post->hero)
                                        <div class="flex-shrink-0 hidden mb-4 md:inline-flex">
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
                                    <h3 class="text-xl font-semibold text-gray-900 capitalize lg:text-2xl">
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
                                        class="overflow-x-hidden text-base text-gray-500 lg:line-clamp-4">
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
    <section class="relative py-16 bg-teal-600">
        <div class="container">
            <h2 class="mb-6 text-3xl text-gray-900">
               <span class="block text-white opacity-90">
                   {{ $snippets->lIDONationCommunity }}
               </span>
            </h2>
            <div class="gridgrid-cols-5gap-6">
                <div class="flex flex-row justify-start w-full gap-6 overflow-x-auto text-white">
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-accent-900 w-44 xl:w-80h-40xl:w-80xl:h-48">
                            <a class="block" href="{{localizeRoute('lido-pool')}}">
                                <img
                                    class="object-cover object-top w-full bg-teal-600 rounded-sm responsive h-28 filter hover:contrast-200"
                                    src="{{$pages?->pool?->hero?->getUrl('thumbnail')}}"
                                    alt="{{$pages?->pool?->hero?->name}}"/>
                            </a>
                        </div>
                        <h3 class="mb-4 text-2xl">
                            <a class="block text-white hover:text-yellow-500" href="{{localizeRoute('lido-pool')}}">
                                {{$pages?->pool?->title}}
                            </a>
                        </h3>
                    </div>
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="flex items-center justify-center p-4 bg-teal-900 w-44">
                            <a href="{{localizeRoute('phuffycoin')}}"
                               class="relative inline-block w-24 h-20 mx-auto rounded-full -top-2 filter hover:contrast-200">
                                @include('svg.phuffycoin-logo')
                            </a>
                        </div>
                        <h3 class="mb-4 text-2xl">
                            <a class="block text-white hover:text-yellow-500" href="{{localizeRoute('phuffycoin')}}">
                                {{ $snippets->learnAboutPhuffycoin }}
                            </a>
                        </h3>
                    </div>
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-phuffy2-700 w-44 xl:w-80h-40xl:w-80xl:h-48">
                            <a class="block" href="{{localizeRoute('financial-details')}}">
                                <img
                                    class="object-cover object-top w-full bg-teal-600 rounded-sm responsive h-28 filter hover:contrast-200"
                                    src="//www.lidonation.com/storage/317/lido-finantial-details-kenny-eliason-unsplash.jpg"
                                    alt="{{$pages?->pool?->hero?->name}}"/>
                            </a>

                        </div>
                        <h3 class="mb-4 text-2xl">
                            <a class="block text-white hover:text-yellow-500"
                               href="{{localizeRoute('financial-details')}}">
                                {{ $snippets->financialDetails }}
                            </a>
                        </h3>
                    </div>
                    <div class="flex flex-col border-b max-w-[11rem] border-white gap-3">
                        <div class="bg-white w-44 xl:w-80h-40xl:w-80xl:h-48">
                            <a class="block" href="{{localizeRoute('contributeContent')}}">
                                <img
                                    class="object-cover object-top w-full bg-teal-600 rounded-sm responsive h-28 filter hover:contrast-200"
                                    src="//www.lidonation.com/storage/318/lidonation-idea-junior-ferreira-unsplash.jpg"
                                    alt="{{$pages?->pool?->hero?->name}}"/>
                            </a>
                        </div>
                        <h3 class="mb-4 text-2xl">
                            <a class="block text-white hover:text-yellow-500"
                               href="{{localizeRoute('contributeContent')}}">
                                {{$snippets->contributeContent}}
                            </a>
                        </h3>
                    </div>

                    <div class="relative inline-flex ml-auto w-80">
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
    <section class="relative py-16 bg-white">
        <div class="container">
            <h2 class="mb-6 text-5xl text-gray-700">
               <span class="">
                   {{ $snippets->explore }}
               </span>
                <span class="block text-teal-600 opacity-90">
                   {{ $snippets->catalystExplorer }}
               </span>
            </h2>
            <div class="grid w-full grid-cols-5 gap-6 overflow-x-auto">
                <div class="flex flex-row gap-6 flex-nowrap">
                    <div class="border border-gray-600 rounded-sm">
                        <div class="bg-white px-2 py-4 border-b border-gray-600 sm:px-6 w-[20rem]">
                            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                                <div class="mt-2 ml-4">
                                    <h3 class="flex items-center gap-1 text-lg font-medium leading-6 text-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-lg font-semibold">
                                            {{ $snippets->importantDates }}
                                        </span>
                                    </h3>
                                </div>
                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <button type="button"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-600 rounded-sm shadow-xs hover:text-white hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                        {{ $snippets->viewCalendar }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <ul role="list" class="divide-y divide-gray-700">
                            @foreach($events as $event)
                                <li class="flex gap-2 p-3">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-white bg-teal-600 rounded-full bold">
                                        {{$event->starts_at->format('d')}}
                                    </div>
                                    <div class="flex-shrink-1">
                                        <p x-data="{ tooltip: @js($event->name) }"
                                           class="font-medium text-gray-900 text-md line-clamp-1">
                                            <span x-tooltip.theme.primary="tooltip">
                                                {{$event->name}}
                                            </span>
                                        </p>
                                        <div class="flex flex-row justify-between gap-1 text-xs text-gray-800">
                                            <div>
                                                <span class="block italic text-gray-500">
                                                    Starts (UTC):
                                                </span>
                                                <span class="font-semibold">
                                                    {{$event->starts_at->format('M d h:i A')}}
                                                </span>
                                            </div>
                                            @if($event->ends_at)
                                                <div>
                                                    <span class="block text-gray-500">
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
                                <h3 class="flex items-center gap-1 text-xl font-semibold leading-6">
                                    <span>
                                        {{ $snippets->catalystNumbers }}
                                    </span>
                                </h3>
                            </div>
                            <div class="flex-shrink-0 ml-4mt-2">
                                <a href="{{localizeRoute('projectCatalyst.dashboard')}}" type="button"
                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-transparent border border-white rounded-sm hover:text-white hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                    {{ $snippets->analytics }}
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap">
                            <hr class="w-full my-0 border-b border-white"/>
                            <div class="p-4">
                                <div class="flex justify-center w-32 h-32 p-4 border border-white rounded-full">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="inline-block text-2xl font-semibold">
                                            ${{humanNumber($stats->completedProposals)}}
                                        </div>
                                        <div class="inline-block text-xs text-center">
                                            {{ $snippets->completedProjects }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-center w-32 h-32 p-4 border border-white rounded-full">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="inline-block text-4xl font-semibold">
                                            {{humanNumber($stats->numberOfBuilders)}}
                                        </div>
                                        <div class="inline-block text-sm text-center">
                                            Builders in Catalyst
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-center w-32 h-32 p-4 border border-white rounded-full">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="inline-block text-4xl font-semibold">
                                            {{humanNumber($stats->proposalsCount)}}
                                        </div>
                                        <div class="inline-block text-xs text-center">
                                            Number of Funded Projects
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-center w-32 h-32 p-4 border border-white rounded-full">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="inline-block text-3xl font-semibold">
                                            ${{humanNumber($stats->avgFundedProposals)}}
                                        </div>
                                        <div class="inline-block text-xs text-center">
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
                                class="absolute top-0 z-20 flex flex-wrap items-center justify-end w-full p-4 sm:flex-nowrap">
                                <a href="{{$catalystArticle->link}}" type="button"
                                   class="inline-flex items-center px-2.5 py-1.5 border border-white text-xs font-medium rounded-sm text-white hover:text-gray-100 bg-teal-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                    View Article
                                </a>
                            </div>
                            <div class="absolute bottom-0 w-full p-2 pb-4">
                                <p class="box-border inline p-2 text-2xl font-semibold leading-9 tracking-wider bg-teal-600 shadow-xs box-decoration-clone">
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
                            <div class="absolute right-0 z-30 flex flex-row justify-end p-4 px-6 bg-transparent">
                                <a href="{{localizeRoute('catalystExplorer.proposals')}}" type="button"
                                   class="inline-flex items-center px-2 py-1 text-xs font-semibold text-white bg-teal-600 border border-white rounded-sm hover:text-white hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                    Explore Proposals
                                </a>
                            </div>
                            <div class="relative z-10 p-4 opacity-50 pointer-events-none">
                                <div class="flex flex-row flex-no-wrap justify-between gap-4">
                                    <h2 class="font-semibold max-w-[70%]">
                                        <a href="{{url('proposals/' . $proposal->slug)}}">
                                        <span class="text-white hover:text-yellow-500">
                                            {{$proposal->title}}
                                        </span>
                                        </a>
                                    </h2>
                                </div>
                                <div class="2xl:h[80px]">
                                    <div class="flex flex-row flex-no-wrap mb-2">
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
                                        class="flex flex-row items-center justify-start gap-1 py-1 border-t border-teal-200">
                                        <a class="font-normal text-white hover:text-white" href="#discussions">
                                            <livewire:ratings.model-average-rating-component
                                                :modelId="$proposal->id"
                                                wire:key="{{$proposal->id}}"
                                                :modelType="\App\Models\Proposal::class"/>
                                        </a>
                                    </div>
                                    <div
                                        class="flex grid flex-row items-center justify-start grid-cols-2 py-2 text-sm space-x2">
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
    <section class="relative py-16 bg-primary-10">
        <div class="container">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-8 xl:gap-16">
                <div class="lg:col-span-6">
                    <h2 class="text-4xl text-gray-700 lg:text-5xl decoratedarkmb-6">
                         <span class="">
                           {{ $snippets->blockchain }}
                       </span>
                        <span class="inline-block text-teal-600 opacity-90">
                           {{ $snippets->insights }}
                       </span>
                    </h2>
                    <div class="flex flex-col gap-6">
                        @if($insights?->isNotEmpty())
                            @foreach($insights as $post)
                                <hr class="border-b border-b-black"/>

                                <div class="flex flex-col gap-4 lg:flex-row-reverse">
                                    @if($post->hero)
                                        <a class="flex-shrink-0 block w-72" href="{{$post->link}}">
                                            @include('post.drip-image')
                                        </a>
                                    @endif

                                    <div class="flex flex-col gap-4">
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

                                        <h3 class="p-0 text-xl font-medium text-black line-clamp-1 2xl:text-3xl xl:line-clamp-2">
                                            <a href="{{$post->link}}">
                                                {{$post->title}}
                                            </a>
                                        </h3>
                                        @if($post->subtitle)
                                            <p class='relative text-lg font-medium xl:text-2xl subtitle'>
                                                {{ $post->subtitle }}
                                            </p>
                                        @endif

                                        <div class="-mt-2">
                                            <x-public.post-meta :post="$post"></x-public.post-meta>
                                        </div>

                                        <div
                                            class="text-sm text-gray-700 md:text-lg line-clamp-6 lg:line-clamp-3 2xl:line-clamp-4">
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
                    <div class="sticky flex flex-col w-full gap-6 top-10">
                        <h2 class="text-3xl text-gray-600">
                            Contributors
                        </h2>
                        <div class="flex flex-col gap-6">
                            @foreach($users as $user)
                                @if($user->hasAllRoles(['super admin', 'editor']))
                                    <x-public.widgets.author :author="$user"/>
                                @endif
                            @endforeach


                            <x-public.widgets.newsletter bg="bg-yellow-500" classes="text-yellow-900" layout="col"/>

                            {{-- <x-public.widgets.meetup :meetups="$meetups" :dayOfWeek="$dayOfWeek"
                                                     :hourOfDay="$hourOfDay"/> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
