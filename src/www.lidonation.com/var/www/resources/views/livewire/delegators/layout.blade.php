<!DOCTYPE html>
<html class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta property="og:site_name" content="{{config('app.name')}}"/>
        <meta property="fb:app_id" content="{{config('services.facebook.app_id')}}"/>

        @stack('openGraph')

        <title>
            {{ ($metaTitle ?? $snippets->siteTitle ) .  ' | ' . Str::title( config('app.name', 'Laravel') . ' ' . $localeDetail?->native)}}
        </title>

        @include('includes.site-icons')

        @include('includes.analytics')

        <link rel="manifest" href="/site.webmanifest">

        @livewireStyles
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
        <link rel="stylesheet" href="{{ asset(mix('css/delegators.css')) }}">

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="h-full delegators" x-data="delegateToLido" x-cloak x-transition.duration.500ms>
        @include('includes.header')

        <main class="flex flex-col bg-white min-h-[68vh]">
            <livewire:delegators.delegators-component />
        </main>

        {{-- include squiggly svg for text animation--}}
        @include('svg.squiggle')

        @include('includes.footer')

        @livewireScripts

        <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
        <script src="{{ mix('js/bootstrap.js') }}"></script>

        <script src="{{ mix('js/delegators.js') }}" defer></script>
    </body>
</html>
