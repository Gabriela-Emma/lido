<div x-data="{
    open: false,
    menu: null,
    init() {}
}" class="flex justify-center lido-menu-wrapper" @toggle-catalyst-menu.window="open = !open">
    <div x-show="open" style="display: none" x-on:keydown.escape.prevent.stop="open = false" role="dialog"
        aria-modal="true" x-id="['modal-title']" :aria-labelledby="$id('modal-title')"
        class="fixed inset-0 z-20 overflow-y-auto lido-menu-wrapper-modal">
        <div x-show="open" x-transition x-on:click="open = false"
            class="relative flex min-h-screen items-start justify-center">
            <div x-on:click.stop x-trap.noscroll.inert="open" class="container mt-10 h-[200px]">
                <div class="relative overflow-y-auto rounded-sm bg-white shadow-lg h-full">
                    <div class="flex flex-row-reverse h-full sm:flex-row p-2 sm:p-0">
                        <div class="p-1 flex flex-col justify-between flex-1 lg:border-slate-800/40 lg:border-r">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
