<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}" />

    @stack('openGraph')
    @stack('tags')

    <title>
        {{ ($metaTitle ?? $snippets->siteTitle) . ' | ' . Str::title(config('app.name', 'Laravel') . ' ' . $localeDetail?->native) }}
    </title>

    @include('includes.site-icons')

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />

    @livewireStyles

    @stack('styles')

    <x-comments::styles />

    @include('includes.analytics')

    <x-feed-links></x-feed-links>

    @stack('json-ld')

    <script src="https:////js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
    </script>

    <!-- @todo move to npm package -->
    <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>

    @livewireScripts

    @vite(['resources/js/lido.ts'])

    @stack('scripts')
</head>

<body x-datax-cloak
    {{ $attributes->merge([
        'class' =>
            'min-h-screen min-w-[320px] relative text-lg xl:text-xl h-0 font-sans text-gray-900 antialiased w-screen ' .
            app()->getLocale() .
            ' ' .
            implode(' ', explode('.', Route::currentRouteName())) .
            (\Illuminate\Support\Facades\Auth::check() &&
            \Illuminate\Support\Facades\Auth::user()?->hasAnyRole(['editor', 'admin', 'super admin'])
                ? ' logged-in admin '
                : ''),
    ]) }}>

    @persist('lido-header')
        @include('includes.header')
    @endpersist

    <main>
        {{ $slot }}
    </main>


    @include('includes.footer')

    <livewire:components.lido-menu lazy="on-load" />

    @persist('lido-global-player')
        <div class="fixed z-40 bottom-8 left-12">
            <livewire:player.global-player />
        </div>
    @endpersist

    <section>
        @include('includes.global-search-handler')
    </section>
</body>

</html>
