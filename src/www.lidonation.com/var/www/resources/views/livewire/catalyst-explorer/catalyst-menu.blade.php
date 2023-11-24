<div class="top-0 z-30 bg-teal-600 border-b border-teal-400 md:border-teal-light-300">
    <div class="container">
        <div
            class="flex flex-row items-center justify-between h-full py-2 overflow-x-auto text-xs md:text-sm flex-nowrap">
            <a href={{ route('catalyst-explorer.home') }} class="text-white hover:text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </a>
            <div>
                <ul class="flex flex-row items-center gap-3">
                    @foreach ($catalystMenu as $menu)
                        <li>
                            <a href="{{ route($menu->route) }}" wire:navigate.hover
                                class="text-white hover:text-yellow-400">
                                <span>{{ $menu->title }}</span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a @click.prevent="$dispatch('toggle-catalyst-menu')" href="#"
                            class="flex justify-between items-center text-white hover:text-yellow-400">More
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>
                    </li>
                    <ul>
                        @include('livewire.catalyst-explorer.catalyst-modal')
            </div>
        </div>
    </div>
</div>
