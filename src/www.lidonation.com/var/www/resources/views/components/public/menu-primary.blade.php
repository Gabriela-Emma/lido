<li class="flow-root menu-item flex items-center h-full" x-data>
    <a href="#" @click.prevent="$dispatch('toggle-lido-menu')" class="inline-flex flex-1 items-center menu-link">
        <span class="font-normal text-xl xl:text-2xl uppercase">
            Menu
        </span>
    </a>
</li>
<li class="flow-root menu-item global-search flex items-center h-full" x-data>
    <a href="#" class="inline-flex items-center menu-link group flex-1 items-center"
       @click.prevent="$dispatch('open-global-search')">
        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-white rounded-sm border border-white shadow-xs group-hover:bg-accent-600 group-focus:outline-none group-focus:ring-2 group-focus:ring-offset-2 group-focus:ring-gray-accent search-btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
    </a>
</li>
