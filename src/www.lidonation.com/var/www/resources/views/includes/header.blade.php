<header id="header" class="relative z-30 h-20 py-2 border-b border-gray-300 md:border-teal-300 md:bg-teal-600">
    <div class="container z-0 h-full">
        <section class="flex flex-row items-center justify-between h-full text-gray-600 md:text-xl">
            <div class='flex flex-row items-center justify-start h-full gap-5'>
                <div class='flex flex-row items-center justify-start h-full gap-a brand-logo-wrapper'>
                    <a href="/" class='inline-block brand-logo-link mr-2'>
                        <img class="hidden md:block logo" width="110" height="110"
                             src="{{asset('img/llogo-transparent.png')}}"
                             alt="lidonation white transparent logo" />

                        <img class="block md:hidden logo" width="110" height="110"
                             src="{{asset('img/llogo-transparent.png')}}"
                             alt="lidonation bare black logo"/>
                    </a>

                    <x-public.site-title></x-public.site-title>
                </div>
            </div>
            <div class="z-20 flex flex-row items-center justify-end h-full gap-1">
                <ul class="z-50 h-full text-white flex flex-row items-center gap-4" id="primary-menu">
                    <x-public.menu-primary></x-public.menu-primary>
                </ul>
            </div>
        </section>
    </div>
</header>
