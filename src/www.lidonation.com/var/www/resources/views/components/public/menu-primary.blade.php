<li class="flex items-center justify-end h-full gap-2 menu-item" x-data>
    <a href="#" @click.prevent="$dispatch('toggle-lido-menu')" class="inline-flex items-center flex-1 menu-link">
        <span class="text-xl font-normal uppercase xl:text-2xl">
            Menu
        </span>
    </a>
</li>
<li id="search" class="flex items-center flow-root h-full menu-item global-search" x-data>
    <a  href="#" class="inline-flex items-center flex-1 menu-link group"
       @click.prevent="$dispatch('open-global-search')">
        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-white rounded-sm border border-white shadow-xs group-hover:bg-accent-600 group-focus:outline-none group-focus:ring-2 group-focus:ring-offset-2 group-focus:ring-gray-accent search-btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
    </a>
</li>
