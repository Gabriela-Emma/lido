<footer class='relative pt-2 pb-6 text-teal-800 bg-teal-600 md:pb-8' aria-labelledby="footerHeading">
    <h2 id="footerHeading" class="sr-only">
       {{$snippets->footer}}
    </h2>

    <div class="container text-sm lg:text-base">
        <!-- First Row -->
        <div class="mb-6 md:flex md:items-center md:justify-between md:mt-0">
            <div
                class='z-10 flex-col items-start justify-center pt-2 pb-8 border-b border-gray-100 border-opacity-90 md:w-3/5 xl:w-2/5 md:h-64 xl:h-80 sm:flex left'>
                <h3 class="text-sm font-semibold tracking-wider text-white uppercase">
                    {{$snippets->lIDOStats}}
                </h3>

                <livewire:lido-stats lazy="on-scroll" />

            </div>

            <div
                class="z-10 text-white border-b border-gray-100 rounded-sm border-opacity-90 lg:px-0 md:h-64 xl:h-80 md:text-gray-700 right">
                <div class="max-w-2xl ml-auto">
                    <livewire:components.pool-picker lazy="on-scroll" theme="transparent" />
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="pb-8 md:grid md:grid-cols-8 lg:grid-cols-8 md:gap-8 lg:gap-4 second">
            <div class="z-10 grid gap-8 sm:grid-cols-2 md:col-span-6">
                <div class="flex flex-row gap-6 md:grid md:grid-cols-2 left">
                    <div>
                        <h3 class="font-semibold tracking-wider text-white uppercase text-md">
                        {{$snippets->learningResources}}
                        </h3>
                        <ul class="mt-4 space-y-4 text-gray-500 md:text-white">
                            <li>
                                <a href="{{localizeRoute('library')}}"
                                   class="font-medium text-white hover:text-yellow-500">
                                   {{$snippets->library}}
                                </a>
                            </li>
{{--                            <li>--}}
{{--                                <a href="{{localizeRoute('news')}}"--}}
{{--                                   class="font-medium text-white hover:text-yellow-500">--}}
{{--                                   {{$snippets->news}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{localizeRoute('insights')}}"--}}
{{--                                   class="font-medium text-white hover:text-yellow-500">--}}
{{--                                   {{$snippets->insights}}--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold tracking-wider text-white uppercase text-md">
                            {{$snippets->gettingStarted}}
                        </h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="{{localizeRoute('what-is-cardano')}}"
                                   class="font-medium text-white capitalize hover:text-yellow-500">
                                   {{$snippets->whatIsCardano}}
                                </a>
                            </li>
                            <li>
                                <a href="{{localizeRoute('what-is-staking')}}"
                                   class="font-medium text-white capitalize hover:text-yellow-500">
                                   {{$snippets->whatIsStaking}}
                                </a>
                            </li>

                            <li>
                                <a href="{{localizeRoute('how-to-buy-ada')}}"
                                   class="font-medium text-white capitalize hover:text-yellow-500">
                                   {{$snippets->howToBuyADA}}
                                </a>
                            </li>

                            <li>
                                <a href="{{localizeRoute('how-to-stake-ada')}}"
                                   class="font-medium text-white capitalize hover:text-yellow-500">
                                   {{$snippets->howToStakeYourADA}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-row gap-6 md:grid md:grid-cols-2 lg:grid-cols-3 sm:gap-0 lg:gap-6 right">
                    <div></div>
                    <div>
                        <h3 class="font-semibold tracking-wider text-white uppercase capitalize text-md md:text-gray-600">
                        {{$snippets->aboutUs}}
                        </h3>
                        <ul class="mt-4 space-y-4 md:text-gray-500">
                            <li>
                                <a href="{{localizeRoute('team')}}" class="font-medium text-white capitalize md:text-gray-500">
                                {{$snippets->theTeam}}
                                </a>
                            </li>
                            <li>
                                <a href="{{localizeRoute('lido-pool')}}"
                                   class="font-medium text-white md:text-gray-500">
                                   {{$snippets->thePool}}
                                </a>
                            </li>
                            <li>
                                <a href="{{localizeRoute('community')}}"
                                   class="font-medium text-white md:text-gray-500">
                                   {{$snippets->theCommunity}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:hidden"></div>
                    <div class="z-10 mt-12 md:mt-0">
                        <h3 class="invisible hidden font-semibold tracking-wider text-white uppercase capitalize text-md lg:block">
                            {{$snippets->aboutUs}}
                        </h3>
                        <ul class="space-y-4 lg:mt-4 md:text-gray-500">
                            <li>
                                <a href="{{localizeRoute('financial-details')}}"
                                   class="font-medium text-white md:text-gray-500">
                                   {{$snippets->financialDetails}}
                                </a>
                            </li>
                            <li>
                                <a href="{{localizeRoute('privacyPolicy')}}"
                                   class="font-medium text-white md:text-gray-500">
                                   {{$snippets->privacyPolicy}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex flex-row md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-2">
                <div class="z-10 mt-12 md:text-right md:mt-0">
                    <h3 class="font-semibold tracking-wider text-white uppercase text-md md:text-gray-600">
                        Tools
                    </h3>
                    <ul class="mt-4 space-y-4 md:text-gray-500">
                        {{-- <li>
                            <a href="{{localizeRoute('contributeContent')}}"
                               class="font-medium text-white md:text-gray-500">
                               {{$snippets->contributeContent}}
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>

        <!-- Third Row -->
        <div class="md:grid md:grid-cols-2 md:mt-0">
            <div
                class='z-10 flex-col items-start justify-center w-full py-8 border-t border-b border-gray-100 h-60 border-opacity-90 lg:h-48 sm:flex left'>
                <h3 class="text-sm font-semibold tracking-wider text-white uppercase">
                    {{$snippets->cardanoStats}}
                </h3>

                <livewire:cardano-stats-component lazy="on-scroll" />
            </div>
            <div class="grid grid-cols-2 gap-6 right">
                <div
                    class="z-10 flex-col justify-center w-full gap-1 py-8 mt-4 border-b border-gray-100 h-60 md:px-4 xl:pl-0 md:border-t lg:h-48 sm:flex md:mt-0 left">
                    <div class=''>
                        <p class="text-white md:text-gray-800">
                        {{$snippets->mailingListCta}}
                        </p>
                    </div>
                    @if(old('emailAddress'))
                        <div>
                            <p>
                                {{$snippets->youDidIt}}
                            </p>
                        </div>
                    @else
                        <div>
                            <x-global.mailchimp-form layout="col"/>
                        </div>
                    @endif
                </div>

                <div class="z-10 py-8 right">
                    <div>
                        <h3 class="font-semibold tracking-wider text-white uppercase text-md md:text-gray-600">

                        {{$snippets->chooseYourLanguage}}
                        </h3>
                        <div class="flex flex-row flex-wrap gap-3">
                            <div>
                                <a href="{{LaravelLocalization::getLocalizedURL('en')}}"
                                   class="inline-block {{app()->getLocale() == 'en' ? 'text-teal-600' : 'text-gray-400'}}">
                                    English
                                </a>
                            </div>
                            <div>
                                <a href="{{LaravelLocalization::getLocalizedURL('es')}}"
                                   class="inline-block {{app()->getLocale() == 'es' ? 'text-teal-600' : 'text-gray-400'}}">
                                    Español
                                </a>
                            </div>
                            <div>
                                <a href="{{LaravelLocalization::getLocalizedURL('sw')}}"
                                   class="inline-block {{app()->getLocale() == 'sw' ? 'text-teal-600' : 'text-gray-400'}}">
                                    Kiswahili
                                </a>
                            </div>
                            <div>
                                <a href="{{LaravelLocalization::getLocalizedURL('fr')}}"
                                   class="inline-block {{app()->getLocale() == 'fr' ? 'text-teal-600' : 'text-gray-400'}}">
                                    Français
                                </a>
                            </div>
                            <div>
                                <a href="{{LaravelLocalization::getLocalizedURL('ja')}}"
                                   class="inline-block {{app()->getLocale() == 'ja' ? 'text-teal-600' : 'text-gray-400'}}">
                                    日本語
                                </a>
                            </div>
                            <div>
                                <a href="{{LaravelLocalization::getLocalizedURL('zh')}}"
                                   class="inline-block {{app()->getLocale() == 'zh' ? 'text-teal-600' : 'text-gray-400'}}">
                                    简体中文
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attribution -->
        <div class="pt-8 md:flex md:items-center md:justify-between">
            <div class="z-10 flex space-x-6 md:order-2">
                <a href="//www.facebook.com/lidonation" class="font-medium text-gray-400 hover:text-gray-300">
                    <span class="sr-only">
                        {{$snippets->facebook}}
                    </span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>

                <a href="//twitter.com/LidoNation" class="font-medium text-gray-400 hover:text-gray-300">
                    <span class="sr-only">
                        {{$snippets->twitter}}
                    </span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                    </svg>
                </a>
            <p class="mt-8 text-base text-teal-50 md:mt-0 md:order-1 copyright">
                &copy;2020 LIDO NATION. {{$snippets->allRightsReserved ?? 'All Rights Reserve.'}}
            </p>
        </div>
    </div>

        <!-- Pool Graphic -->
    <div class='absolute bottom-0 right-0 z-0 hidden w-3/5 h-full px-4 overflow-hidden bg-white md:block pool-graphic'>
        <div class="w-[75rem] text-teal-600 absolute top-24 lg:top-20 left-[-54rem] z-0 transform rotate-[132deg]">
            @include('svg.lido-2')
        </div>
    </div>
</footer>
