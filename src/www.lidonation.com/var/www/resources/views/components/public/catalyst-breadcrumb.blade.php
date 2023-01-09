<div class="sticky top-0 z-30 border-b border-gray-300 md:border-primary-300 md:bg-teal-600 bg-teal-600 page-nav">
    <div class='container relative'>
        <nav class="w-full relative">
            <ul class="flex flex-row items-center justify-end gap-2 py-2 text-xs md:text-sm flex-nowrap overflow-x-auto">
                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('projectCatalyst.dashboard') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                    href="{{localizeRoute('projectCatalyst.dashboard')}}">
                        {{ $snippets->reports }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
