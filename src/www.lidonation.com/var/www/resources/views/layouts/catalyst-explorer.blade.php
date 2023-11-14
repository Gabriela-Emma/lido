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

        @livewireStyles

        @env('production')
            <!-- Cloudflare Web Analytics -->
            <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
                    data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>

            <!-- Fathom - beautiful, simple website analytics  -->
            <script src="https://essential-jazzy.lidonation.com/script.js" data-spa="auto"
                    data-site="{{config('services.fathom.site')}}" defer></script>
            <!-- / Fathom -->
        @endenv


        <!-- Scripts -->
        @routes

        @inertiaHead
    </head>
    <body x-data x-cloak class="font-sans antialiased catalyst-explorer-app">
        <livewire:components.lido-menu lazy="on-load" />

        @include('includes.header')

        <main>
            @inertia
        </main>

        @include('svg.squiggle')

        @include('includes.footer')

        @livewireScripts

        @vite(['resources/js/apps/catalyst-explorer/app.ts'])

        @include('includes.global-search-handler')
    </body>
</html>
