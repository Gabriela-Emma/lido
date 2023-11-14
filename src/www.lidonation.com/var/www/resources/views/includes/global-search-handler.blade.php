<div x-data="{openGlobalSearch: false}" x-cloak x-transition
     @open-global-search.window="openGlobalSearch = true"
     @close-global-search.window="openGlobalSearch = false"
     x-show="openGlobalSearch"
     x-trap.noscroll.inert="openGlobalSearch"
     class="bg-gray-400 bg-opacity-60 absolute z-50 w-full h-full overflow-hidden global-search-wrapper">
    <div class="w-full top-0 fixed bg-white right-0 h-full shadow-sm z-50">
        <livewire:global-search.global-search-component />
    </div>
</div>
