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
        {{ ( $title ?? $metaTitle ?? $snippets->siteTitle) . ' | ' . Str::title(config('app.name', 'Lido Nation') . ' ' . $localeDetail?->native) }}
    </title>

    @include('includes.site-icons')

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-video@0.8.0/dist/css/splide-extension-video.min.css">


    @stack('styles')

    @livewireStyles

    <x-comments::styles />

    @include('includes.analytics')

    <x-feed-links></x-feed-links>

    @stack('json-ld')
</head>
<body x-data {{Route::currentRouteName() != 'phuffycoin' && Route::currentRouteName() != 'governanceMarathon' &&  Route::currentRouteName() != 'delegators' ? 'x-cloak' : ''}}
    {{$attributes->merge([
        'class' => 'min-h-screen min-w-[320px] relative text-lg xl:text-xl h-0 font-sans text-gray-900 antialiased w-screen ' . app()->getLocale() . ' ' . implode(' ', explode('.', Route::currentRouteName())) . (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()?->hasAnyRole(['editor','admin', 'super admin']) ? ' logged-in admin ' : '')
    ])}}>

@include('includes.top-banner')

@include('includes.global-search-handler')

<div class="absolute top-0 right-0 w-screen overflow-hidden pointer-events-none h-130 top-pool-wrapper" id="top-blob">
    <div
        class="sm:-right-40 lg:right-[-44rem] xl:right[-60rem] 2xl:right-[-45rem] 3xl:right-[-70rem] 4xl:right-[-90rem] transform rotate-115 relative -top-50 text-teal-600 h-full">
        @include('svg.lido-1')
    </div>
</div>

{{-- Admin bar --}}
@hasanyrole('editor|admin|super admin')
<section class='w-full h-[40px] bg-slate-800 text-white z-40 relative text-xs'>
    <div class="container h-full">
        <div class="flex flex-row items-center justify-between h-full">
            <div >
                @stack('editLink')
            </div>
            <div class="flex flex-row">
                <div class="text-sm">{{$snippets->hello}}, {{$user->name}}</div>
            </div>
        </div>
    </div>
</section>
@endhasanyrole

@include('includes.header')

<main>
    {{ $slot }}
</main>

<!-- slte popup modal -->
<x-slte-popup-modal />

{{-- include squiggly svg for text animation--}}
@include('svg.squiggle')

@include('includes.footer')


<section>
    <!-- Scripts -->
{{--    @livewireScripts--}}

    <script src="//js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{config('services.stripe.key')}}");
    </script>

    <!-- @todo move to npm package -->
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
    <script src="https://unpkg.com/three@0.150.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-video@0.8.0/dist/js/splide-extension-video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    @stack('scripts')

    @vite(['resources/js/lido.ts'])

    <!-- Dynamic tailwind classes -->
    <span class="hidden text-white md:visible xl:invisible md:w-8 md:h-8"></span>
    <span class="sm:max-w-2xl sm:max-w-3xl sm:max-w-4xl sm:max-w-5xl sm:max-w-6xl sm:max-w-7xl 2xl:max-w-4xl 2xl:max-w-5xl 2xl:max-w-6xl 2xl:max-w-7xl "></span>
</section>

<livewire:components.lido-menu lazy="on-load" />
</body>
</html>
