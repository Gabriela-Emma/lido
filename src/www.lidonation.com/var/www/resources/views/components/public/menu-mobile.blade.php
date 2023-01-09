<section id="mobile-menu" class="fixed inset-0 overflow-hidden z-50 lg:hidden"
         aria-labelledby="slide-over-title"
         role="dialog"
         aria-modal="true"
         x-data="mobileMenu()"
         x-show="showing"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0 "
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-on:toggle-mobile-menu.window="toggle()">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="absolute inset-y-0 right-0 pl-20 max-w-full flex"
             x-show="showing"
             x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            <div class="w-screen max-w-sm">
                <div class="h-screen flex flex-col justify-start bg-white overflow-y-scroll">
                    <div class="border-b h-20">
                        <div class="px-4 py-4 sm:px-6 flex items-center h-20 justify-between">
                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                <x-public.site-title></x-public.site-title>
                            </h2>
                            <div class="ml-3 h-7 flex items-center">
                                <button @click="toggle()"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="relative flex-1 px-4 sm:px-6">
                        <ul class="pt-5 space-y-6 flex flex-col justify-start">
                            <x-public.menu-primary></x-public.menu-primary>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
