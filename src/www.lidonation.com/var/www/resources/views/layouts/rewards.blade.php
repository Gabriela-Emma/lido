<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset(mix('css/rewards.css')) }}">

    @env('production')
        <!-- Cloudflare Web Analytics -->
        <script defer src='//static.cloudflareinsights.com/beacon.min.js'
                data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>

        <!-- Fathom - beautiful, simple website analytics  -->
        <script src="https://essential-jazzy.lidonation.com/script.js" data-spa="auto"
                data-site="{{config('services.fathom.site')}}" defer></script>
        <!-- / Fathom -->
    @endenv

    @routes
    <script src="{{ mix('/js/alpine.js') }}" defer></script>
    <script src="{{ mix('/js/rewards.js') }}" defer></script>

    @inertiaHead
</head>
<body class="rewards">

<x-lido-menu />

@include('includes.global-search-handler')

@include('includes.header')

<main>
    @inertia
</main>


{{-- include squiggly svg for text animation--}}
@include('svg.squiggle')

@include('includes.footer')

{{--<livewire:global-player-component />--}}

</body>
</html>
