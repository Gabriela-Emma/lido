<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

    @env('production')
        <!-- Cloudflare Web Analytics -->
        <script defer src='//static.cloudflareinsights.com/beacon.min.js'
                data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>

        <!-- Fathom - beautiful, simple website analytics  -->
        <script src="https://essential-jazzy.lidonation.com/script.js" data-site="{{config('services.fathom.site')}}" defer></script>
        <!-- / Fathom -->
    @endenv

    <script src="{{ mix('/js/app.js') }}" defer></script>
    @inertiaHead
</head>
<body>
    @include('includes.header')

    <main>
        @inertia
    </main>

    {{-- include squiggly svg for text animation--}}
    @include('svg.squiggle')

    @include('includes.footer')

    <x-public.menu-mobile></x-public.menu-mobile>
</body>
</html>
