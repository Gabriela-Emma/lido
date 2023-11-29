<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:site_name" content="{{config('app.name')}}"/>
    <meta property="fb:app_id" content="{{config('services.facebook.app_id')}}"/>
    @stack('openGraph')
    @stack('tags')

    <title>
        {{ ($metaTitle ?? $snippets->siteTitle ) .  ' | ' . Str::title( config('app.name', 'Laravel') . ' ' . $localeDetail?->native)}}
    </title>

    @include('includes.site-icons')

    <link rel="manifest" href="/site.webmanifest">

    <!-- Styles -->
    <link rel="stylesheet" href="//unpkg.com/tippy.js@6/dist/tippy.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />

    <link rel="stylesheet" href="{{ asset(mix('css/splide-core.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/splide-default.min.css')) }}">

    @stack('styles')

    @livewireStyles
    {{--@bukStyles(true)--}}

    <x-comments::styles />

    {{--<link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">--}}

    @include('includes.analytics')

    @env('local')
        <script src="//localhost:35729/livereload.js"></script>
    @endenv

    <x-feed-links></x-feed-links>

    @stack('json-ld')
</head>
<body x-data {{Route::currentRouteName() != 'phuffycoin' && Route::currentRouteName() != 'governanceMarathon' &&  Route::currentRouteName() != 'delegators' ? "x-cloak" : ''}}
    {{'min-h-screen min-w-[320px] relative text-lg xl:text-xl h-0 font-sans text-gray-900 antialiased w-screen ' . app()->getLocale() . ' ' . implode(' ', explode('.', Route::currentRouteName())) . (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()?->hasAnyRole(['editor','admin', 'super admin']) ? ' logged-in admin ' : '')
    }}>

    {{--@include('includes.global-search-handler')--}}

    <div class="absolute top-0 right-0 w-screen overflow-hidden pointer-events-none h-130 top-pool-wrapper" id="top-blob">
        <div
            class="sm:-right-40 lg:right-[-44rem] xl:right[-60rem] 2xl:right-[-45rem] 3xl:right-[-70rem] 4xl:right-[-90rem] transform rotate-115 relative -top-50 text-teal-600 h-full">
            @include('svg.lido-1')
        </div>
    </div>

    {{-- Admin bar --}}
    @hasanyrole('editor|admin|super admin')
    <section class='w-full h-[40px] bg-slate-800 text-white z-40 relative text-xs'>
        <div class="container h-full">
            <div class="flex flex-row justify-between h-full items-center">
                <div >
                    @stack('editLink')
                </div>
                <div class="flex flex-row">
                    <div class="text-sm">{{$snippets->hello}}, {{$user->name}}</div>
                </div>
            </div>
        </div>
    </section>
    @endhasanyrole

    @include('includes.header')

    <main>
        <div title="Contribute Content">
            <x-public.page-header :size="'md'">
                <x-slot name="title">
                    <span class='font-light'>{{__('Contribute') }}</span><br/>
                    <div class='font-black text-teal-600 flex flex-row justify-start items-end gap-3 relative -bottom-6'>
                        <div>
                            <svg class="text-teal-600 h-20 w-20 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 48 48"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            {{__('Contribute') }}
                        </div>
                    </div>
                </x-slot>
                <p class="mt-1">
                    Your perspective is valuable.
                </p>
                <p class="mt-1">
                    Contribute articles, ideas, voice recordings, translations, reviews, and more!
                </p>
            </x-public.page-header>

            {{--    <div class="max-w-5xl mx-auto">--}}
            {{--        <livewire:contribute-content.contribute-translation />--}}
            {{--    </div>--}}

            <section class="relative bg-white relative py-16">
                <div class="container">
                    <div class="text-center">
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 3xl:grid-cols-4">
                            {{--                    <div class="pt-6">--}}
                            {{--                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">--}}
                            {{--                            <div class="-mt-6">--}}
                            {{--                                <div>--}}
                            {{--                                    <button--}}
                            {{--                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-idea")'--}}
                            {{--                                        type="button"--}}
                            {{--                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-secondary-500 rounded-sm shadow-xs">--}}
                            {{--                                        Submit Idea--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                            {{--                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">--}}
                            {{--                                    Got an Idea ?--}}
                            {{--                                </h3>--}}
                            {{--                                <div class="mt-2 font-normal">--}}
                            {{--                                    <div>Submit a new topic</div>--}}
                            {{--                                    <div>--}}
                            {{--                                        and vote for other ideas here.--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}

                            {{--                    <div class="pt-6">--}}
                            {{--                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">--}}
                            {{--                            <div class="-mt-6">--}}
                            {{--                                <div>--}}
                            {{--                                    <button--}}
                            {{--                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-article")'--}}
                            {{--                                        type="button"--}}
                            {{--                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-600 rounded-sm shadow-xs">--}}
                            {{--                                        Submit Article--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                            {{--                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">--}}
                            {{--                                    News & Insights--}}
                            {{--                                </h3>--}}
                            {{--                                <div class="mt-2 font-normal">--}}
                            {{--                                    <p>--}}
                            {{--                                        Give us your perspective on the headlines.--}}
                            {{--                                        <br/>What should everyone understand--}}
                            {{--                                        <br/>about cryptos and Cardano?--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}

                            {{--                    <div class="pt-6">--}}
                            {{--                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">--}}
                            {{--                            <div class="-mt-6">--}}
                            {{--                                <div>--}}
                            {{--                                    <button--}}
                            {{--                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-review")'--}}
                            {{--                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-600 rounded-sm shadow-xs">--}}
                            {{--                                        Submit Review--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                            {{--                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">--}}
                            {{--                                    Write a Review--}}
                            {{--                                </h3>--}}
                            {{--                                <div class="mt-2 font-normal">--}}
                            {{--                                    <p>--}}
                            {{--                                        As you explore crypto tools, projects, website, apps and DApps - what do you--}}
                            {{--                                        think--}}
                            {{--                                        about what you see?--}}
                            {{--                                    </p>--}}
                            {{--                                    <p>--}}
                            {{--                                        We provide the template; your provide the opinions.--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}

                            {{--                    <div class="pt-6">--}}
                            {{--                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">--}}
                            {{--                            <div class="-mt-6">--}}
                            {{--                                <div>--}}
                            {{--                                    <button--}}
                            {{--                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-translation")'--}}
                            {{--                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-yellow-600 rounded-sm shadow-xs">--}}
                            {{--                                        Translate Content--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                            {{--                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">--}}
                            {{--                                    Gracias - Asante - 谢谢--}}
                            {{--                                </h3>--}}
                            {{--                                <div class="mt-2 font-normal">--}}
                            {{--                                    <p>--}}
                            {{--                                        Do you speak Swahili, Spanish, Chinese, Japanese, or French?--}}
                            {{--                                        <br/>Help translate content!--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}

                            <div class="pt-6">
                                <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                                    <div class="-mt-6">
                                        <div>
                                            <button
                                                onclick='Livewire.emit("openModal", "contribute-content.contribute-recording")'
                                                class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-pink-600 rounded-sm shadow-xs">
                                                Record Article
                                            </button>
                                        </div>

                                        <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                            Lend us your voice!
                                        </h3>

                                        <div class="mt-2 font-normal">
                                            <p>
                                                Voice recordings make website content accessible to more people.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                                    <div class="-mt-6">
                                        <div>
                                            <a
                                                href="{{route('earn.contribute.content')}}"
                                                class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-800 rounded-sm shadow-xs">
                                                Contribute Article
                                            </a>
                                        </div>

                                        <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                            LidoNation Content Contributor FAQ
                                        </h3>

                                        <div class="mt-2 font-normal">
                                            <p>
                                                How much? What topics?
                                                <br/>How can I get started?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                                    <div class="-mt-6">
                                        <div>
                                            <button
                                                onclick='Livewire.emit("openModal", "contribute-content.contribute-money")'
                                                class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-800 rounded-sm shadow-xs">
                                                Give Money
                                            </button>
                                        </div>

                                        <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                            Support LIDO Nation
                                        </h3>

                                        <div class="mt-2 font-normal">
                                            <p>
                                                Donate cash, btc, ada,
                                                <br/>or stake to <strong>LIDO</strong> pool.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--                    <div class="pt-6">--}}
                            {{--                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">--}}
                            {{--                            <div class="-mt-6">--}}
                            {{--                                <div>--}}
                            {{--                                    <a--}}
                            {{--                                        href="{{ route('portal') }}"--}}
                            {{--                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-800 rounded-sm shadow-xs">--}}
                            {{--                                        Portal--}}
                            {{--                                    </a>--}}
                            {{--                                </div>--}}

                            {{--                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">--}}
                            {{--                                    Go to your portal--}}
                            {{--                                </h3>--}}

                            {{--                                <div class="mt-2 font-normal">--}}
                            {{--                                    <p>--}}
                            {{--                                        Manage your account, validate wallet, see contribute stats, etc.--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- slte popup modal -->
    <x-slte-popup-modal />

    {{-- include squiggly svg for text animation--}}
    @include('svg.squiggle')

    @include('includes.footer')

    <x-lido-menu />

    <section>
        <!-- Scripts -->
{{--        @livewireScripts--}}

        <script src="//js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe("{{config('services.stripe.key')}}");
        </script>

        <!-- @todo move to npm package -->
        <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
        <script src="https://unpkg.com/three@0.150.0/build/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
        <script src="{{ mix('vendor/splide/splide-shader-carousel.min.js') }}"></script>

        {{--<script src="{{ mix('js/global.js') }}" ></script>--}}

        @if (Route::currentRouteName() != 'phuffycoin' && Route::currentRouteName() != 'delegators' && Route::currentRouteName() != 'governanceMarathon' )
            {{--<script src="{{ mix('js/app.js') }}" defer></script>--}}
        @endif
        @vite(['resources/js/lido.ts'])

        @stack('scripts')

        {{--<script src="{{ mix('js/bootstrap.js') }}"></script>--}}

        <!-- Dynamic tailwind classes -->
        <span class="hidden md:visible xl:invisible md:w-8 md:h-8 text-white"></span>
        <span class="sm:max-w-2xl sm:max-w-3xl sm:max-w-4xl sm:max-w-5xl sm:max-w-6xl sm:max-w-7xl 2xl:max-w-4xl  2xl:max-w-5xl  2xl:max-w-6xl 2xl:max-w-7xl "></span>
    </section>



    {{--<livewire:global-player-component />--}}
    <link rel="preload" href="{{ asset(mix('css/catalyst-explorer.css')) }}" as="style">

</body>
</html>

