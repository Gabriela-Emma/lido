<div x-data="{
    open: true,
    menu: null,
    init() {}
 }"
     class="flex justify-center" @toggle-lido-menu.window="open = !open">
    <!-- Modal -->
    <div
        x-show="open"
        style="display: none"
        x-on:keydown.escape.prevent.stop="open = false"
        role="dialog"
        aria-modal="true"
        x-id="['modal-title']"
        :aria-labelledby="$id('modal-title')"
        class="fixed top-20 inset-0 z-10 overflow-y-auto"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Panel -->
        <div
            x-show="open" x-transition
            x-on:click="open = false"
            class="relative flex min-h-screen items-start justify-center p-2"
        >
            <div
                x-on:click.stop
                x-trap.noscroll.inert="open"
                class="container"
            >
                <div class="relative overflow-y-auto rounded-sm bg-white shadow-lg">
                    <div class="flex flex-col-reverse items-start justify-between sm:flex-row flex-wrap">
                        <div class="p-6 flex flex-col justify-between h-full flex-1">
                            <div>
                                <p class="mt-2 text-gray-600">
                                    Are you sure you want to learn how to create an awesome modal?
                                </p>
                            </div>

                            <div class="flex flex-row w-full text-center text-white">
                                <a href="{{LaravelLocalization::getLocalizedURL('en')}}" class="flex-1 p-2 bg-teal-600 text-white hover:text-white">
                                    English
                                </a>
                                <a href="{{LaravelLocalization::getLocalizedURL('es')}}" class="flex-1 p-2 bg-yellow-600 text-white hover:text-white">
                                    Español
                                </a>
                                <a href="{{LaravelLocalization::getLocalizedURL('sw')}}" class="flex-1 p-2 bg-pink-600 text-white hover:text-white">
                                    Kiswahil
                                </a>
                            </div>
                        </div>

                        <div class="w-80 h-full min-h-full border-l border-slate-800/40 p-6">
                            <div class="top-1 right-1 absolute">
                                <button type="button" x-on:click="open = false"
                                        class="rounded-sm bg-white hover:bg-slate-200 p-1.5 text-slate-600 z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <a href="{{localizeRoute('delegators')}}#everyEpoch" class="flex flex-col gap-4 px-6">
                                <img class="block" src="{{asset('img/every-epoch-logo.png')}}" alt="Every Epoch logo">
                                <span class="block text-center">
                                    Every Epoch
                                </span>
                                <span
                                    class="block text-center text-base text-slate-500 hover:text-slate-500 font-normal">
                                    Learn, Play, & Win<br/>every 5 days!
                                </span>
                                <span
                                    class="text-center flex flex-col gap-1 text-base text-slate-500 hover:text-slate-500 font-normal">
                                    <span>$PHUFFY</span>
                                    <span>$HOSKY</span>
                                    <span>$NMKR</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
