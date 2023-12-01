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

{{--    <link rel="manifest" href="/site.webmanifest">--}}

    <!-- Styles -->
    <link rel="stylesheet" href="//unpkg.com/tippy.js@6/dist/tippy.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />

    @stack('styles')

    @livewireStyles

    <x-comments::styles />

    @include('includes.analytics')

    <x-feed-links></x-feed-links>

    @stack('json-ld')
</head>
<body class="h-full delegators" x-cloak x-transition.duration.500ms
    x-data="earnCcv4" >
    <livewire:components.lido-menu lazy="on-load" />

    @include('includes.header')

    <main class="flex flex-col px-8 bg-white min-h-[68vh]">
        {{ $slot }}
    </main>

    {{-- include squiggly svg for text animation--}}
    @include('svg.squiggle')

    @include('includes.footer')

    <!-- Scripts -->
    @livewireScriptConfig

    @include('includes.global-search-handler')

    @vite(['resources/js/earn-ccv4.ts'])



    @if (Route::currentRouteName() != 'phuffycoin' && Route::currentRouteName() != 'delegators' && Route::currentRouteName() != 'governanceMarathon' )
    @endif

    @stack('scripts')

    <!-- Dynamic tailwind classes -->
    <span class="hidden text-white md:visible xl:invisible md:w-8 md:h-8"></span>
    <span class="sm:max-w-2xl sm:max-w-3xl sm:max-w-4xl sm:max-w-5xl sm:max-w-6xl sm:max-w-7xl 2xl:max-w-4xl 2xl:max-w-5xl 2xl:max-w-6xl 2xl:max-w-7xl "></span>

</body>
</html>
