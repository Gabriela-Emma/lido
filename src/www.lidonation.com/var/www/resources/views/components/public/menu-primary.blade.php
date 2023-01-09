<li class="flow-root menu-item">
    <a href="#" @click="$dispatch('toggle-lido-menu')" class="flex menu-link {{ request()->routeIs('projectCatalyst.*') ? 'active' : '' }}">
        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <span class="font-normal text-xl xl:text-2xl uppercase">
            Menu
        </span>
    </a>
</li>
<li class="flow-root menu-item global-search" x-data>
    <a href="#" class="inline-flex items-center menu-link group"
       @click="$dispatch('open-global-search')">
    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-white rounded-sm border border-white shadow-xs group-hover:bg-accent-600 group-focus:outline-none group-focus:ring-2 group-focus:ring-offset-2 group-focus:ring-gray-accent search-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </span>
    </a>
</li>
{{--<li--}}
{{--class="relative z-30 flow-root menu-item"--}}
{{--x-data="{}" x-on:mouseenter="$dispatch('show-cardano-menu')"--}}
{{--x-on:click.stop="$dispatch('toggle-cardano-menu')">--}}
{{--    <span class="flex menu-link md:hidden">--}}
{{--        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />--}}
{{--        </svg>--}}
{{--        <span class="px-1 font-bold text-gray-700">--}}
{{--            {{$snippets->whatIsCardano}}--}}
{{--        </span>--}}
{{--    </span>--}}
{{--    <span class="flex items-center hidden text-gray-500 group md:inline-flex menu-link hover:cursor-pointer" aria-expanded="false">--}}
{{--        <span>--}}
{{--            {{$snippets->whatIsCardano}}--}}
{{--        </span>--}}
{{--        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />--}}
{{--        </svg>--}}
{{--    </span>--}}
{{--    <x-public.cardano-flyout></x-public.cardano-flyout>--}}
{{--</li>--}}

{{--<li class="flow-root menu-item">--}}
{{--    <a href="{{localizeRoute('projectCatalyst.projects')}}" class="flex menu-link {{ request()->routeIs('projectCatalyst.*') ? 'active' : '' }}">--}}
{{--        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />--}}
{{--        </svg>--}}
{{--        <span class="px-1">--}}
{{--            {{$snippets->catalystExplorer}}--}}
{{--        </span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--<li class="flow-root menu-item">--}}
{{--    <a href="{{localizeRoute('library')}}" class="flex menu-link {{ request()->routeIs('library') ? 'active' : '' }}">--}}
{{--        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />--}}
{{--        </svg>--}}
{{--        <span class="px-1">--}}
{{--            {{$snippets->library}}--}}
{{--        </span>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="flow-root menu-item">--}}
{{--    <a href="{{localizeRoute('delegators')}}" class="flex menu-link {{ request()->routeIs('delegators') ? 'active' : '' }}">--}}
{{--        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />--}}
{{--        </svg>--}}
{{--        <span class="px-1">--}}
{{--            {{$snippets->delegators}}--}}
{{--        </span>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="flow-root menu-item">--}}
{{--    <a href="{{localizeRoute('bazaar')}}" class="flex menu-link {{ request()->routeIs('bazaar') ? 'active' : '' }}">--}}
{{--        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />--}}
{{--        </svg>--}}
{{--        <span class="px-1">--}}
{{--            {{$snippets->bazaar}}--}}
{{--        </span>--}}
{{--    </a>--}}
{{--</li>--}}
{{--<li class="flow-root menu-item">--}}
{{--    <a href="{{localizeRoute('community')}}" class="flex menu-link {{ request()->routeIs('community') ? 'active' : '' }}">--}}
{{--        <svg class="flex-shrink-0 block w-6 h-6 text-gray-400 md:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />--}}
{{--        </svg>--}}
{{--        <span class="px-1">--}}
{{--            {{$snippets->connect}}--}}
{{--        </span>--}}
{{--    </a>--}}
{{--</li>--}}

