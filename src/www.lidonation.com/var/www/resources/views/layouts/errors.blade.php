<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:site_name" content="{{config('app.name')}}"/>
    <meta property="fb:app_id" content="{{config('services.facebook.app_id')}}"/>
    @stack('openGraph')


    <title>
        @isset($title)
            @if(!empty($title))
                {{ $title }} |
            @endif
        @endisset
        {{ config('app.name', 'Laravel') }}
    </title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/splide-default.min.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles
    @bukStyles(true)

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GT4QM779D7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', "{{config('services.analytics.id')}}");
    </script>

    @env('local')
        <script src="http://localhost:35729/livereload.js"></script>
    @endenv
    <x-feed-links></x-feed-links>
</head>
<body
    {{$attributes->merge(['class' => 'min-h-screen min-w-[320px] relative text-lg xl:text-xl h-0 font-sans text-gray-900 antialiased w-screen overflow-x-hidden'])}}>
<main>
    <div class="bg-white min-h-screen flex flex-col lg:relative">
        <div class="flex-grow flex flex-col">
            <main class="flex-grow flex flex-col bg-white">
                <div class="flex-grow mx-auto max-w-7xl w-full flex flex-col px-4 sm:px-6 lg:px-8">
                    <div class="flex-shrink-0 pt-10 sm:pt-16">
                        <a href="/" class="inline-flex">
                            <span class="sr-only">Workflow</span>
                            <img class="h-20 w-auto"
                                 src="{{asset('img/llogo-transparent.png')}}" alt="lidonation logo">
                        </a>
                    </div>
                    {{ $slot }}
                </div>
            </main>
            <footer class="flex-shrink-0 bg-gray-50">
                <div class="mx-auto max-w-7xl w-full px-4 py-16 sm:px-6 lg:px-8">
                    <nav class="flex space-x-4">
                        <a href="{{route('home')}}" class="text-sm font-medium text-gray-500">Home</a>
                        <span class="inline-block border-l border-gray-300" aria-hidden="true"></span>
                        <a href="{{route('community')}}" class="text-sm font-medium text-gray-500">Connect</a>
                        <span class="inline-block border-l border-gray-300" aria-hidden="true"></span>
                        <a href="//twitter.com/LidoNation" class="text-sm font-medium text-gray-500">Twitter</a>
                    </nav>
                </div>
            </footer>
        </div>
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="absolute inset-0 h-full w-full object-cover"
                 src="https://images.unsplash.com/photo-1470847355775-e0e3c35a9a2c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1825&q=80"
                 alt="">
        </div>
    </div>
</main>
<section>
    @livewireScripts
</section>
</body>
</html>
