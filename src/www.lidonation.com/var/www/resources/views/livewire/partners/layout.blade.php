<!DOCTYPE html>
<html class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta property="og:site_name" content="{{config('app.name')}}"/>
        <meta property="fb:app_id" content="{{config('services.facebook.app_id')}}"/>

        <title>
            {{ ($metaTitle ?? $snippets->siteTitle ) .  ' | ' . Str::title( config('app.name', 'Laravel') . ' ' . $localeDetail?->native)}}
        </title>

        <link rel="manifest" href="/site.webmanifest">

        @livewireStyles

        <link rel="stylesheet" href="{{ asset(mix('css/partners.css')) }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('includes.analytics')
    </head>
    <body class="h-full" x-data="lidoPartners">
        @include('includes.global-search-handler')

        @include('includes.header')

        @unlessrole('partner')
            <main class="flex flex-col bg-white min-h-[68vh]" x-cloak>
                <livewire:partners.login-component />
            </main>
        @endunlessrole

        @role('partner')
            <main class="flex flex-col bg-white lg:h-[80vh]" x-cloak>
                @include('livewire.partners.app')
            </main>
        @endrole


        {{-- include squiggly svg for text animation--}}
        @include('svg.squiggle')

        @include('includes.footer')

        <x-lido-menu />

        {{--<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v3.10.5/dist/alpine.min.js" defer></script>--}}
        @livewireScripts

        <script src="{{ mix('js/partners.js') }}" defer></script>

        <script src="{{ mix('js/bootstrap.js') }}"></script>
    </body>
</html>
