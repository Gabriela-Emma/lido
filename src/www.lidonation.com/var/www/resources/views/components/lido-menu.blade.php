<div x-data="{
    open: false,
    menu: null,
    init() {}
 }"
     class="flex justify-center lido-menu-wrapper" @toggle-lido-menu.window="open = !open">
    <!-- Modal -->
    <div
        x-show="open"
        style="display: none"
        x-on:keydown.escape.prevent.stop="open = false"
        role="dialog"
        aria-modal="true"
        x-id="['modal-title']"
        :aria-labelledby="$id('modal-title')"
        class="fixed inset-0 z-20 overflow-y-auto lido-menu-wrapper-modal"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-white/25 lido-menu-wrapper-modal-overlay"></div>

        <!-- Panel -->
        <div
            x-show="open" x-transition
            x-on:click="open = false"
            class="relative flex min-h-screen items-start justify-center lido-menu-wrapper-modal-panel"
        >
            <div
                x-on:click.stop
                x-trap.noscroll.inert="open"
                class="container"
            >
                <div class="relative overflow-y-auto rounded-sm bg-white shadow-lg h-full">
                    <div class="flex flex-row-reverse h-full sm:flex-row p-2 sm:p-0">
                        <div class="p-1 flex flex-col justify-between flex-1 lg:border-slate-800/40 lg:border-r">
                            <div class="p-3 mb-4">
                                <nav class="columns-2 sm:columns-3 lg:columns-4 2xl:columns-5 gap-5  lido-menu" x-data
                                     x-masonry.poll.2500>
                                    <div class="lg:hidden w-36 md:w-44 mb-8">
                                        @include('includes.lido-menu-feature')
                                    </div>

                                    @foreach($lidoMenu as $menu)
                                        @include('includes.lido-menu-items')
                                    @endforeach

                                    @auth()
                                        @php
                                            $user = \Illuminate\Support\Facades\Auth::user();
                                            $title = "Welcome  {$user?->name}";
                                            $items = [];
                                            if ($user->hasAnyRole([
                                                \App\Enums\RoleEnum::proposer()?->value,
                                                 \App\Enums\RoleEnum::catalyst_profile()->value
                                                 ])) {
                                                $items[] = new Illuminate\Support\Fluent([
                                                       'title' => 'My Catalyst Dashboard',
                                                       'route_type' => 'route_name',
                                                       'route' => 'catalystExplorer.myDashboard',
                                                   ]);
                                            }
                                            $userMenu = (new \App\Invokables\GetLidoMenu)([new Illuminate\Support\Fluent(compact('title', 'items'))]);
                                        @endphp
                                        <div class="border border-slate-600 p-2 break-inside-avoid user-menu-wrapper">
                                            @foreach($userMenu as $menu)
                                                @include('includes.lido-menu-items')
                                            @endforeach

                                            <div
                                                class="inline-flex items-center text-xs md:text-base font-medium text-gray-900 ease-in-out hover:text-teal-800"
                                                x-data="{
                                                async logout() {
                                                    await window.axios.post('/logout');
                                                    document.location.reload();
                                                }
                                            }">
                                                <a href="#" @click.prevent="logout"
                                                   class="inline-block text-black font-bold">Logout</a>
                                            </div>
                                        </div>
                                    @endauth
                                </nav>
                            </div>

                            <div class="flex flex-row w-full text-center text-white">
                                <a href="{{LaravelLocalization::getLocalizedURL('en')}}"
                                   class="flex-1 p-2 bg-teal-600 text-white hover:text-white">
                                    English
                                </a>
                                <a href="{{LaravelLocalization::getLocalizedURL('es')}}"
                                   class="flex-1 p-2 bg-yellow-600 text-white hover:text-white">
                                    Español
                                </a>
                                <a href="{{LaravelLocalization::getLocalizedURL('sw')}}"
                                   class="flex-1 p-2 bg-pink-600 text-white hover:text-white">
                                    Kiswahil
                                </a>
                            </div>
                        </div>

                        <div class="hidden lg:flex lg:w-60 2xl:w-72">
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

                            <div class="lg:flex flex-col">
                                @include('includes.lido-menu-feature')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
