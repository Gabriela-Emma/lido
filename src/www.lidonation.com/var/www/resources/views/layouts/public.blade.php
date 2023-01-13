<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
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
    @bukStyles(true)

    <x-comments::styles />

    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

    @include('includes.analytics')

    @env('local')
        <script src="//localhost:35729/livereload.js"></script>
    @endenv

    <x-feed-links></x-feed-links>

    @stack('json-ld')
</head>
<body x-data {{Route::currentRouteName() != 'phuffycoin' && Route::currentRouteName() != 'governanceMarathon' &&  Route::currentRouteName() != 'delegators' ? 'x-cloak' : ''}}
    {{$attributes->merge([
        'class' => 'min-h-screen min-w-[320px] relative text-lg xl:text-xl h-0 font-sans text-gray-900 antialiased w-screen ' . app()->getLocale() . ' ' . implode(' ', explode('.', Route::currentRouteName()))
    ])}}>

    @include('includes.global-search-handler')

    <div class="absolute top-0 right-0 w-screen overflow-hidden pointer-events-none h-130 top-pool-wrapper" id="top-blob">
        <div
            class="sm:-right-40 lg:right-[-28rem] xl:right[-60rem] 2xl:right-[-45rem] 3xl:right-[-70rem] 4xl:right-[-90rem] transform rotate-115 relative -top-50 text-teal-600 h-full">
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
        {{ $slot }}
    </main>

    {{-- include squiggly svg for text animation--}}
    @include('svg.squiggle')

    @include('includes.footer')

    <x-lido-menu />

    <section>
        <!-- Scripts -->
        @livewireScripts

        <script src="//js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe("{{config('services.stripe.key')}}");
        </script>

        <!-- @todo move to npm package -->
        <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
        <script src="https://unpkg.com/three@0.140.2/build/three.min.js"></script>
        <script src="{{ mix('vendor/splide/splide-shader-carousel.min.js') }}"></script>

        <script src="{{ mix('js/global.js') }}" ></script>

        @if (Route::currentRouteName() != 'phuffycoin' && Route::currentRouteName() != 'delegators' && Route::currentRouteName() != 'governanceMarathon' )
            <script src="{{ mix('js/app.js') }}" defer></script>
        @endif

        @stack('scripts')

        <script src="{{ mix('js/bootstrap.js') }}"></script>

        <!-- Dynamic tailwind classes -->
        <span class="hidden md:visible xl:invisible md:w-8 md:h-8 text-white"></span>
        <span class="sm:max-w-2xl sm:max-w-3xl sm:max-w-4xl sm:max-w-5xl sm:max-w-6xl sm:max-w-7xl 2xl:max-w-4xl  2xl:max-w-5xl  2xl:max-w-6xl 2xl:max-w-7xl "></span>
    </section>

    <x-comments::scripts />

    <livewire:global-player-component />
</body>
</html>
