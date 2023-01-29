<x-public-layout class="overflow-x-hidden lido-minute-podcast" :metaTitle="$metaTitle">
    <header class="py-16">
        <div class="container">
            <h1 class="text-3xl font-light leading-8 tracking-tight text-slate-800 sm:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl pr-8 xl:pr-20 2xl:max-w-7xl">
                <span class="font-extrabold text-yellow-500">LIDO Minute.</span>
                <span>Bite size podcast for Blockchain & Cardano education.</span>
            </h1>
        </div>
    </header>


    <div class="container">
        @if($newEpisodes)
        <section class="splide minute-splide relative bg-primary-10 mb-16 relative" id="new-lido-minutes">
            <div class="splide__track">
                <div class="splide__list gap-2 episodes">
                    @foreach($newEpisodes as $post)
                        <div class="splide__slide w-[380px] lg:w-[420px] xl:w-[480px] 2xl:w-[540px]">
                            @include('podcast.drip')
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    </div>

    <section class="relative bg-white py-16">
        <div class="absolute inset-x-0 bottom-0 hidden h-1/2 bg-yellow-500 lg:block" aria-hidden="true"></div>
        <div class="mx-auto max-w-7xl bg-yellow-500 lg:bg-transparent lg:px-8">
            <div class="lg:grid lg:grid-cols-12">
                <div class="relative z-10 lg:col-span-4 lg:col-start-1 lg:row-start-1 lg:bg-transparent lg:py-16">
                    <div class="absolute inset-x-0 h-1/2 bg-gray-50 lg:hidden" aria-hidden="true"></div>
                    <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-none lg:p-0">
                        <div class="aspect-w-10 aspect-h-6 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1">
                            <img class="rounded-xl object-cover object-center shadow-2xl"
                                 src="https://images.unsplash.com/photo-1507207611509-ec012433ff52?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=934&q=80"
                                 alt="">
                        </div>
                    </div>
                </div>

                <div
                    class="relative bg-slate-800 lg:col-span-10 overflow-hidden lg:col-start-3 lg:row-start-1 lg:grid lg:grid-cols-10 lg:items-center lg:rounded-3xl">
                    <div
                        class="absolute inset-0 hidden -right-24 bottom-4 h-full lg:flex flex-col justify-center items-end text-yellow-500/50 opacity-25 overflow-hidden rounded-3xl"
                        aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-72 w-72">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <div
                        class="relative mx-auto max-w-md space-y-6 py-12 px-4 sm:max-w-3xl sm:py-16 sm:px-6 lg:col-span-6 lg:col-start-4 lg:max-w-none lg:p-0">
                        <h2 class="text-3xl xl:text-4xl font-bold tracking-tight text-yellow-500" id="join-heading">
                            Sponsor an Episode
                        </h2>
                        <p class="text-lg xl:text-xl text-yellow-500 font-medium">
                            Put your ad message next to an episode of the Lido Minute + Powered by Cardano NFTs
                        </p>
                        <a class="block w-full rounded-sm border border-transparent bg-yellow-500 py-3 px-5 text-center text-base font-medium text-slate-800 shadow-sm hover:bg-yellow-600 sm:inline-block sm:w-auto"
                           href="{{localizeRoute('lido-minute-nft')}}">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-white py-12 lg:py-16 ">
        <div class="container">
            <div class="lg:grid lg:grid-cols-2 lg:items-center lg:gap-8">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Recent episodes on a platform near you
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg text-gray-500">
                        The best place to experience the lido minute podcast is here on lidonation.com where you can
                        access many more minutes,
                        more contexts and additional related content.
                    </p>
                    <p class="mt-3 max-w-3xl text-lg text-gray-500">
                        For LIDO Minutes on the go we also publish recent episodes to wherever you listen to podcasts.
                    </p>
                </div>
                <div class="mt-8 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-0 lg:grid-cols-2">
                    <div class="col-span-1 flex justify-center items-center gap-2 bg-gray-50 py-8 px-8">
                        <img class="max-h-12 grayscale" src="/img/audible-podcast-black.png" alt="Audible">
                        <span>Audible</span>
                    </div>
                    <div class="col-span-1 flex justify-center items-center gap-2 bg-gray-50 py-8 px-8">
                        <img class="max-h-12 grayscale" src="/img/youtube-podcast-black.png" alt="YouTube">
                        <span>YouTube</span>
                    </div>
                    <div class="col-span-1 flex justify-center items-center gap-2 bg-gray-50 py-8 px-8">
                        <img class="max-h-12 grayscale" src="/img/google-podcast-logo.png" alt="Google Podcast">
                        <span>Google Podcast</span>
                    </div>
                    <div class="col-span-1 flex justify-center items-center gap-2 bg-gray-50 py-8 px-8">
                        <img class="max-h-12 grayscale" src="/img/stitcher-podcast-black.png" alt="Stitcher">
                        <span>Stitcher</span>
                    </div>
                    <div class="col-span-1 flex justify-center items-center gap-2 bg-gray-50 py-8 px-8">
                        <img class="max-h-12 grayscale" src="/img/itunes-black.png" alt="itunes">
                        <span>iTunes</span>
                    </div>
                    <div class="col-span-1 flex justify-center items-center gap-2 bg-gray-50 py-8 px-8">
                        <img class="max-h-12 grayscale" src="/img/spotify-podcast-black.png" alt="Spotify">
                        <span>Spotify</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{--    <section class="">--}}
    {{--        <div class="container py-4">--}}
    {{--            <div--}}
    {{--                x-data="{--}}
    {{--                skip: 3,--}}
    {{--                atBeginning: false,--}}
    {{--                atEnd: false,--}}
    {{--                next() {--}}
    {{--                    this.to((current, offset) => current + (offset * this.skip))--}}
    {{--                },--}}
    {{--                prev() {--}}
    {{--                    this.to((current, offset) => current - (offset * this.skip))--}}
    {{--                },--}}
    {{--                to(strategy) {--}}
    {{--                    let slider = this.$refs.slider--}}
    {{--                    let current = slider.scrollLeft--}}
    {{--                    let offset = slider.firstElementChild.getBoundingClientRect().width--}}
    {{--                    slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })--}}
    {{--                },--}}
    {{--                focusableWhenVisible: {--}}
    {{--                    'x-intersect:enter'() {--}}
    {{--                        this.$el.removeAttribute('tabindex')--}}
    {{--                    },--}}
    {{--                    'x-intersect:leave'() {--}}
    {{--                        this.$el.setAttribute('tabindex', '-1')--}}
    {{--                    },--}}
    {{--                },--}}
    {{--                disableNextAndPreviousButtons: {--}}
    {{--                    'x-intersect:enter.threshold.05'() {--}}
    {{--                        let slideEls = this.$el.parentElement.children--}}

    {{--                        // If this is the first slide.--}}
    {{--                        if (slideEls[0] === this.$el) {--}}
    {{--                            this.atBeginning = true--}}
    {{--                        // If this is the last slide.--}}
    {{--                        } else if (slideEls[slideEls.length-1] === this.$el) {--}}
    {{--                            this.atEnd = true--}}
    {{--                        }--}}
    {{--                    },--}}
    {{--                    'x-intersect:leave.threshold.05'() {--}}
    {{--                        let slideEls = this.$el.parentElement.children--}}

    {{--                        // If this is the first slide.--}}
    {{--                        if (slideEls[0] === this.$el) {--}}
    {{--                            this.atBeginning = false--}}
    {{--                        // If this is the last slide.--}}
    {{--                        } else if (slideEls[slideEls.length-1] === this.$el) {--}}
    {{--                            this.atEnd = false--}}
    {{--                        }--}}
    {{--                    },--}}
    {{--                },--}}
    {{--            }"--}}
    {{--                class="flex w-full flex-col  border-t border-slate-800"--}}
    {{--            >--}}
    {{--                <div class="flex justify-end gap-2">--}}
    {{--                    <!-- Prev Button -->--}}
    {{--                    <button--}}
    {{--                        x-on:click="prev"--}}
    {{--                        class="text-6xl"--}}
    {{--                        :aria-disabled="atBeginning"--}}
    {{--                        :tabindex="atEnd ? -1 : 0"--}}
    {{--                        :class="{ 'opacity-50 cursor-not-allowed': atBeginning }"--}}
    {{--                    >--}}
    {{--                            <span aria-hidden="true">--}}
    {{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
    {{--                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">--}}
    {{--                                  <path stroke-linecap="round" stroke-linejoin="round"--}}
    {{--                                        d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"/>--}}
    {{--                                </svg>--}}
    {{--                            </span>--}}
    {{--                        <span class="sr-only">Skip to previous slide page</span>--}}
    {{--                    </button>--}}

    {{--                    <!-- Next Button -->--}}
    {{--                    <button--}}
    {{--                        x-on:click="next"--}}
    {{--                        class="text-6xl"--}}
    {{--                        :aria-disabled="atEnd"--}}
    {{--                        :tabindex="atEnd ? -1 : 0"--}}
    {{--                        :class="{ 'opacity-50 cursor-not-allowed': atEnd }"--}}
    {{--                    >--}}
    {{--                            <span aria-hidden="true">--}}
    {{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
    {{--                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">--}}
    {{--                                  <path stroke-linecap="round" stroke-linejoin="round"--}}
    {{--                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>--}}
    {{--                                </svg>--}}
    {{--                            </span>--}}
    {{--                        <span class="sr-only">Skip to next slide page</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}

    {{--                <div--}}
    {{--                    x-on:keydown.right="next"--}}
    {{--                    x-on:keydown.left="prev"--}}
    {{--                    tabindex="0"--}}
    {{--                    role="region"--}}
    {{--                    aria-labelledby="carousel-label"--}}
    {{--                    class="flex space-x-6">--}}
    {{--                    <h2 id="carousel-label" class="sr-only" hidden>Recent episodes</h2>--}}

    {{--                    <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>--}}

    {{--                    <div--}}
    {{--                        x-ref="slider"--}}
    {{--                        tabindex="0"--}}
    {{--                        role="listbox"--}}
    {{--                        aria-labelledby="carousel-content-label"--}}
    {{--                        class="flex w-full snap-x snap-mandatory overflow-x-scroll gap-3"--}}
    {{--                    >--}}
    {{--                        @foreach($newEpisodes as $episode)--}}
    {{--                            <div class="bg-white shadow-sm rounded-sm p-2 podcast-wrapper">--}}
    {{--                                <div x-bind="disableNextAndPreviousButtons"--}}
    {{--                                     class="flex w-1/3 shrink-0 snap-start flex-col items-start justify-center podcast-inner"--}}
    {{--                                     role="option">--}}
    {{--                                    <img class="mt-2 w-full" src="{{$episode->thumbnail_url}}"--}}
    {{--                                         alt="placeholder image">--}}

    {{--                                    <button x-bind="focusableWhenVisible"--}}
    {{--                                            class="py-2 text-xl font-semibold text-slate-800">--}}
    {{--                                        {{$episode->title}}--}}
    {{--                                    </button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

</x-public-layout>
