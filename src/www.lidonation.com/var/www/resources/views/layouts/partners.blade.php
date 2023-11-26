<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="fb:app_id" content="{{ config('services.facebook.app_id') }}" />

    <title>
        {{ ( $title ?? $metaTitle ?? $snippets->siteTitle) . ' | ' . Str::title(config('app.name', 'Lido Nation') . ' ' . $localeDetail?->native) }}
    </title>

    @livewireStyles

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--    @include('includes.analytics') --}}

    {{--    @livewireScripts --}}

    @vite(['resources/js/partners.ts'])

    @include('includes.global-search-handler')

    @stack('scripts')
</head>

<body class="h-full" x-data="lidoPartners">

    @include('includes.header')

    @unlessrole('partner')
        <main class="flex flex-col bg-white min-h-[68vh]" x-cloak >
            <livewire:partners.connect-component />
        </main>
    @endunlessrole

    @role('partner')
        <main class="flex flex-col bg-white lg:h-[80vh]" x-cloak >
            @include('livewire.partners.app')
        </main>
    @endrole

    {{-- <main class="flex flex-col bg-white lg:h-[80vh]" x-cloak>
        {{ $slot }}
    </main> --}}

    @include('includes.footer')

    <livewire:components.lido-menu lazy="on-load" />
{{--    @livewireScriptConfig--}}
</body>

</html>
