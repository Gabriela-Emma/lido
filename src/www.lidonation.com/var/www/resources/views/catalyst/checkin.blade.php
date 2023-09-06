<x-public-layout class="catalyst-group" >
    @livewire('catalyst.catalyst-sub-menu-component')
    <header class="text-white bg-teal-600">
        <div class="container">
        </div>
    </header>
    <section class="text-white bg-teal-600">
        <div class="container py-16">
            <div class="bg-teal-700">
            <div class="relative overflow-hidden isolate bg-gradient-to-b from-indigo-100/20">
                <div class="pt-10 pb-24 mx-auto max-w-7xl sm:pb-32 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-40">
                <div class="px-6 lg:px-0 lg:pt-4">
                    <div class="max-w-2xl mx-auto">
                    <div class="max-w-lg">
                        <div class="mt-24 sm:mt-32 lg:mt-16">
                        <a href="#" class="inline-flex space-x-6">
                            <span class="px-3 py-1 text-sm font-semibold leading-6 text-yellow-600 rounded-full bg-teal-light-600/50 ring-1 ring-inset ring-indigo-600/10">
                                New
                            </span>
                        </a>
                        </div>
                        <h1 class="mt-10 text-4xl font-bold tracking-tight sm:text-6xl">
                            Build your Cardano reputation with Project Catalyst.
                        </h1>
                        <p class="mt-6 text-lg leading-8">
                            Catalyst Checkin issues you verifiable credentials on the Cardano blockchain for participating in Project Catalyst.
                        </p>
                        <div class="flex items-center mt-10 gap-x-6">
                        {{-- <a href="#" class="rounded-sm bg-teal-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yello-600">
                            Documentation
                        </a> --}}
                        {{-- <a href="#" class="text-sm font-semibold leading-6">View on GitHub <span aria-hidden="true">→</span></a> --}}
                        </div>
                    </div>
                    </div>
                </div>
                <div class="mt-20 sm:mt-24 md:mx-auto md:max-w-2xl lg:mx-0 lg:mt-0 lg:w-screen">
                    <div class="absolute inset-y-0 right-1/2 -z-10 -mr-10 w-[200%] skew-x-[-30deg] bg-teal-800 shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 md:-mr-20 lg:-mr-36" aria-hidden="true"></div>
                    <div class="shadow-lg md:rounded-3xl">
                    <div class="bg-teal-500 [clip-path:inset(0)] md:[clip-path:inset(0_round_theme(borderRadius.3xl))]">
                        <div class="absolute -inset-y-px left-1/2 -z-10 ml-10 w-[200%] skew-x-[-30deg] bg-indigo-100 opacity-20 ring-1 ring-inset ring-white md:ml-20 lg:ml-36" aria-hidden="true"></div>
                        <div class="relative px-6 pt-8 sm:pt-16 md:pl-16 md:pr-0">
                        <div class="max-w-2xl mx-auto md:mx-0 md:max-w-none">
                            <div class="w-screen overflow-hidden bg-gray-900 rounded-tl-xl">
                            {{-- <div class="flex bg-gray-800/40 ring-1 ring-white/5">
                                <div class="flex -mb-px text-sm font-medium leading-6">
                                <div class="px-4 py-2 text-white border-b border-r border-b-white/20 border-r-white/10 bg-white/5">NotificationSetting.jsx</div>
                                <div class="px-4 py-2 border-r border-gray-600/10">App.jsx</div>
                                </div>
                            </div> --}}
                            <div class="px-6 pt-6 pb-14">
                                QR code will get rendered and embeded here
                                <img {{ asset('img/townhall-2023-09-06.png')}} />
                            </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 pointer-events-none ring-1 ring-inset ring-black/10 md:rounded-3xl" aria-hidden="true"></div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="absolute inset-x-0 bottom-0 h-24 -z-10 bg-gradient-to-t from-teal-800 sm:h-32"></div>
            </div>
            </div>
        </div>
    </section>
</x-public-layout>
