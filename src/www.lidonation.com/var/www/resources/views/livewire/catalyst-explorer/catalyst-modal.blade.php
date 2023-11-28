<div x-data="{
    open: false,
    menu: null,
    init() {}
}" class="flex justify-center" @toggle-catalyst-menu.window="open = !open">
    <div x-show="open" style="display: none" x-on:keydown.escape.prevent.stop="open = false" role="dialog"
        aria-modal="true" x-id="['modal-title']" :aria-labelledby="$id('modal-title')"
        class="fixed inset-0 z-20 overflow-y-auto">
        <div x-show="open" x-transition x-on:click="open = false"
            class="relative flex min-h-screen items-start justify-center">
            <div x-on:click.stop x-trap.noscroll.inert="open" class="container mt-32 h-[200px]">
                <div class="relative overflow-y-auto rounded-sm bg-white shadow-lg h-full p-3">
                    <div class="flex flex-row-reverse h-full sm:flex-row p-2 sm:p-0">
                        <div x-on:click="open = false"
                            class="columns-2 sm:columns-3 lg:columns-4 2xl:columns-5 p-3 mx-2">
                            <ul>
                                @foreach ($catalystMenu as $menu)
                                    @if ($loop->index > 4)
                                        <p class="text-slate-700 text-xl font-semibold">
                                            {{ $menu?->title }}
                                        </p>
                                        @foreach ($menu?->items as $m)
                                            @if($m?->route_type === 'route_name')
                                            <li class="mb-1">
                                                <a class="text-gray-900 hover:text-teal-800 font-normal text-lg"
                                                    href={{ $m->route }}>
                                                    {{ $m->title }}
                                                </a>
                                            </li>
                                            @else
                                            <li class="mb-1">
                                                <a class="text-gray-900 hover:text-teal-800 font-normal text-lg"
                                                    href="{{ $m->route }}">
                                                    {{ $m->title }}
                                                </a>
                                            </li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
