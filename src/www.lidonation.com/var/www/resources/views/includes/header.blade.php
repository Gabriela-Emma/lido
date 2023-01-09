<header id="header" class="relative z-30 h-20 py-2 border-b border-gray-300 md:border-teal-300 md:bg-teal-600">
    <div class="container z-0 h-full">
        <section class="flex flex-row items-center justify-between h-full text-gray-600 md:text-xl">
            <div class='flex flex-row items-center justify-start h-full gap-5'>
                <div class='flex flex-row items-center justify-start h-full gap-a brand-logo-wrapper'>
                    <a href="/" class='inline-block brand-logo-link mr-2'>
                        <img class="hidden md:block logo" width="110" height="110"
                             src="{{asset('img/llogo-transparent.png')}}"
                             alt="lidonation white transparent logo"/>

                        <img class="block md:hidden logo" width="110" height="110"
                             src="{{asset('img/llogo-transparent.png')}}"
                             alt="lidonation bare black logo"/>
                    </a>

                    <x-public.site-title></x-public.site-title>
                </div>
            </div>
            <div class="z-20 flex flex-row items-center justify-end h-full gap-1">
                <ul class="z-10 z-50 flex-col hidden h-full text-white md:flex md:flex-row" id="primary-menu">
                    <x-public.menu-primary></x-public.menu-primary>
                </ul>
                <a x-data href="#" class="inline-flex items-center bg-gray-200 md:hidden"
                   @click="$dispatch('open-global-search')">
                        <span class="inline-flex items-center px-2.5 py-2.5 text-xs font-semibold text-white rounded-sm border border-white shadow-xs group-hover:bg-accent-600 group-focus:outline-none group-focus:ring-2 group-focus:ring-offset-2 group-focus:ring-gray-accent search-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                </a>
                <button x-data="{}"
                        class="relative inline-flex items-center justify-center px-1 ml-2 text-base bg-gray-800 rounded-sm md:hidden hover:bg-gray-700 focus:outline-none"
                        x-on:click="$dispatch('toggle-mobile-menu')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-10 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h8m-8 6h16"/>
                    </svg>
                </button>
            </div>
        </section>
    </div>
</header>
