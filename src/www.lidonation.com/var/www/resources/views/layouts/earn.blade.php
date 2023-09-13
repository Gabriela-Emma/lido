<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="google" content="notranslate" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset(mix('css/earn.css')) }}">

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

    <script src="{{ mix('/js/alpine.js') }}" defer></script>
    <script src="{{ mix('/js/earn.js') }}" defer></script>

    @if(app()->getLocale() === 'sw' || auth()?->user()?->hasRole(\App\Enums\RoleEnum::super_admin()->value))
        @inertiaHead
    @endif
</head>
<body class="earn {{Route::is('earn.learn.*') || Route::is('earn.learn') ? 'learn' : ''}}">

@include('includes.top-banner')

<x-lido-menu/>

@include('includes.global-search-handler')

@include('includes.header')

<main>
    @if(!Route::is('earn.learn.*') || app()->getLocale() === 'sw' || auth()?->user()?->hasRole(\App\Enums\RoleEnum::super_admin()->value))
        @inertia
    @else
        <section class="container py-16">
            <div class="flex flex-col items-center justify-center">
                <div class="py-6 text-center text-labs-black">
                    <h3 class=" xl:text-4xl">Only Available in Swahili</h3>
                    <p class="max-w-sm mx-auto">
                        Inakuja hivi karibuni is a Blockchain User learning program only available in Swahili.
                    </p>
                </div>
                <div
                    class="relative flex flex-col w-auto rounded-sm bg-gradient-to-b from-teal-900 to-teal-500 overflow-clip">
                    <div class="flex items-start justify-between p-4 border-b border-teal-200">
                        <h2 class="w-auto font-medium text-gray-300 brightness-100">
                            Inakuja hivi karibuni
                        </h2>
                    </div>

                    <div class="relative min-w-[22rem] lg:min-w-[32rem] max-w-7xl mx-auto p-4">
                        <div class="flex flex-col gap-8 text-slate-100">
                            <div>
                                <div class="flex items-start gap-4 text-white">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 font-semibold bg-white rounded-full text-slate-800">
                                        1
                                    </div>
                                    <div>
                                        <h2 class="flex items-center gap-2 text-white">
                                            <span>{{$snippets->learn}}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor"
                                                 class="w-6 h-6 text-yellow-50">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                                            </svg>
                                        </h2>
                                        <div class="max-w-sm">
                                            <p>
                                                Read an article about blockchain in plain Swahili.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-start gap-4 text-white">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 font-semibold bg-white rounded-full text-slate-800">
                                        2
                                    </div>
                                    <div>
                                        <h2 class="flex items-center gap-2 text-white">
                                    <span>
                                        {{$snippets->quiz}}
                                    </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor"
                                                 class="w-6 h-6 text-green-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                                            </svg>
                                        </h2>
                                        <div class="max-w-md">
                                            <p>
                                                Answer a few multiple-choice questions about the article. No trick
                                                questions, we promise.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div>
                                <div class="flex items-start gap-4 text-white">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 font-semibold bg-white rounded-full text-slate-800">
                                        3
                                    </div>
                                    <div>
                                        <h2 class="flex items-center gap-2 text-white">
                                            <span>{{$snippets->earn}}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor"
                                                 class="w-6 h-6 text-amber-400">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </h2>
                                        <div class="max-w-sm">
                                            <p>
                                                Once you pass the quiz, you earn ada. Complete modules, earn nft
                                                bonuses.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <footer class="flex justify-center w-full p-4 mt-4">
                            <a type="button" href="{{localizeRoute('earn.learn', 'sw')}}"
                               class="inline-flex items-center gap-x-2 rounded-sm bg-labs-red px-3.5 py-2.5 text-sm xl:text-xl font-semibold text-white hover:text-black shadow-sm hover:bg-labs-red-light focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-red-light">
                                {{$snippets->goToSwahili}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/>
                                </svg>
                            </a>
                        </footer>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </section>
    @endif
</main>

{{-- include squiggly svg for text animation--}}
@include('svg.squiggle')

@include('includes.footer')

<script src="{{ mix('js/bootstrap.js') }}"></script>

<script src="{{ mix('js/global.js') }}"></script>

</body>
</html>
