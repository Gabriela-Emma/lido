<div class="h-full">
    <div class="relative z-40 md:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-opacity-75 bg-slate-600"></div>

        <div class="fixed inset-0 z-40 flex">
            <!--
              Off-canvas menu, show/hide based on off-canvas menu state.

              Entering: "transition ease-in-out duration-300 transform"
                From: "-translate-x-full"
                To: "translate-x-0"
              Leaving: "transition ease-in-out duration-300 transform"
                From: "translate-x-0"
                To: "-translate-x-full"
            -->
            <div class="relative flex flex-col flex-1 w-full max-w-xs bg-white">
                <!--
                  Close button, show/hide based on off-canvas menu state.

                  Entering: "ease-in-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                  Leaving: "ease-in-out duration-300"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="absolute top-0 right-0 pt-2 -mr-12">
                    <button type="button"
                            class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x-mark -->
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <nav class="px-2 mt-5 space-y-1">
                        <!-- Current: "bg-slate-100 text-slate-900", Default: "text-slate-600 hover:bg-slate-50 hover:text-slate-900" -->
                        <a href="#"
                           class="flex items-center px-2 py-2 text-base font-medium rounded-md bg-slate-100 text-slate-900 group">
                            <!--
                              Heroicon name: outline/home

                              Current: "text-slate-500", Default: "text-slate-400 group-hover:text-slate-500"
                            -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-4 text-slate-500" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                            Dashboard
                        </a>
                    </nav>
                </div>
                <div class="flex flex-shrink-0 p-4 border-t border-slate-200">
                    <a href="#" class="flex-shrink-0 block group">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block w-10 h-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-medium text-slate-700 group-hover:text-slate-900">Tom
                                    Cook</p>
                                <p class="text-sm font-medium text-slate-500 group-hover:text-slate-700">View
                                    profile</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="grid h-full grid-cols-12">
        <div class="hidden col-span-2 md:inset-y-0 md:flex md:w-64 md:flex-col bg-slate-100">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex flex-col h-full min-h-0 px-6 border-r flex1 border-slate-200 bg-slate-50">
                <div class="flex flex-col justify-start h-full pt-5 pb-4 overflow-y-auto flex1">
                    <nav class="flex1 bg-slate-50">
                        <!-- Current: "bg-slate-100 text-slate-900", Default: "text-slate-600 hover:bg-slate-50 hover:text-slate-900" -->
                        <a href="#"
                           class="flex items-center px-2 py-2 text-sm font-medium text-slate-900 group rounded-xs">
                            <!--
                              Heroicon name: outline/home

                              Current: "text-slate-500", Default: "text-slate-400 group-hover:text-slate-500"
                            -->
                            <svg class="flex-shrink-0 w-6 h-6 mr-3 text-slate-500" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                            Dashboard
                        </a>
                    </nav>
                </div>
                <div class="flex flex-shrink-0 p-4 mt-auto border-t border-slate-200">
                    <div class="flex-shrink-0 block w-full group">
                        <div class="flex items-center">
                            <div>
                                <span class="inline-block w-10 h-10 rounded-full bg-eggplant-600"></span>
{{--                                <img class="inline-block rounded-full h-9 w-9"--}}
{{--                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"--}}
{{--                                     alt="">--}}
                            </div>
                            <div class="flex flex-col gap-1 ml-3">
                                <p class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Welcome, {{$user?->name}}</p>
                                <a href="#" @click="partnerLogout" class="text-xs font-medium text-slate-400 group-hover:text-teal-700">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container relative flex flex-col col-span-10 overflow-y-auto flex1">
            <div class="sticky top-0 z-10 pt-1 pl-1 bg-white sm:pl-3 sm:pt-3 md:hidden">
                <button type="button"
                        class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-slate-500 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">
                            Open sidebar
                        </span>
                    <!-- Heroicon name: outline/bars-3 -->
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>

            <main class="overflow-y-auto">
                {{ $slot }}
            </main>

            <section class="absolute z-40 w-full bg-transparent pointer-events-none bottom-4 right-1">
                <x-notice />
            </section>
        </div>
    </div>
</div>

