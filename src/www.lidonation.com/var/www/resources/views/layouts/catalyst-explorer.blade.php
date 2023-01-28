<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset(mix('css/catalyst-explorer.css')) }}">

    @env('production')
        <!-- Cloudflare Web Analytics -->
        <script defer src='//static.cloudflareinsights.com/beacon.min.js'
                data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>

        <!-- Fathom - beautiful, simple website analytics  -->
        <script src="https://essential-jazzy.lidonation.com/script.js" data-site="{{config('services.fathom.site')}}" defer></script>
        <!-- / Fathom -->
    @endenv

    <script src="{{ mix('/js/alpine.js') }}" defer></script>
    <script src="{{ mix('/js/catalyst-explorer.js') }}" defer></script>

    @inertiaHead
</head>
<body>

<x-lido-menu />

@include('includes.global-search-handler')

@include('includes.header')

<main>
    @inertia
</main>

{{-- include squiggly svg for text animation--}}
@include('svg.squiggle')

@include('includes.footer')

<script src="{{ mix('js/bootstrap.js') }}"></script>

{{--<livewire:global-player-component />--}}

</body>
</html>
