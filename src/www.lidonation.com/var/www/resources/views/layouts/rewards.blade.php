<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'Lido Nation') }}</title>

@env('production')
        <!-- Cloudflare Web Analytics -->
        <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
                data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>

        <!-- Fathom - beautiful, simple website analytics  -->
        <script src="https://essential-jazzy.lidonation.com/script.js" data-spa="auto"
                data-site="{{config('services.fathom.site')}}" defer></script>
        <!-- / Fathom -->
    @endenv

    @routes

    @livewireStyles

    @inertiaHead
</head>
<body class="rewards" x-data x-cloak>

<livewire:components.lido-menu lazy="on-load"/>

@include('includes.header')

<main>
    @inertia
</main>

{{-- include squiggly svg for text animation--}}
@include('svg.squiggle')

@include('includes.footer')

@livewireScripts

@include('includes.global-search-handler')

@vite(['resources/js/apps/rewards/app.ts'])

</body>
</html>
