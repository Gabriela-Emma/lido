<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @include('includes.site-icons')

        @include('includes.analytics')

        <!-- Scripts -->
        @routes

        @inertiaHead

        @livewireStyles
    </head>
    <body x-data x-cloak class="font-sans antialiased delegators-app">
        <livewire:components.lido-menu lazy="on-load" />

        @include('includes.header')

        <main>
            @inertia
        </main>

        @include('svg.squiggle')

        @include('includes.footer')

{{--        @livewireScripts--}}

        @include('includes.global-search-handler')

        @vite(['resources/js/apps/delegators/app.ts'])
    </body>
</html>
