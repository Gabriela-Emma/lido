<div class="sticky top-0 z-30 border-b border-teal-400 md:border-teal-300 md:bg-teal-light-500 bg-teal-light-500 page-nav">
    <div class='container relative'>
        <nav class="relative w-full">
            <ul class="flex flex-row items-center justify-end gap-2 py-2 overflow-x-auto text-xs md:text-sm flex-nowrap">

                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalyst-explorer.charts') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                       href="{{localizeRoute('catalyst-explorer.charts')}}">
                        {{ $snippets->reports }}
                    </a>
                </li>
                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalyst-explorer.funds.index') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                       href="{{localizeRoute('catalyst-explorer.funds.index')}}">
                        {{ $snippets->funds }}
                    </a>
                </li>
                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalyst-explorer.proposals') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                       href="{{localizeRoute('catalyst-explorer.proposals')}}">
                        {{ $snippets->projects }}
                    </a>
                </li>

                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalyst-explorer.people.index') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                       href="{{localizeRoute('catalyst-explorer.people.index')}}">
                        {{ $snippets->people }}
                    </a>
                </li>
                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalyst-explorer.groups') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                       href="{{localizeRoute('catalyst-explorer.groups')}}">
                        {{ $snippets->groups }}
                    </a>
                </li>
                <li class="flow-root menu-item">
                    <a class="px-1 py-3 text-white menu-link whitespace-nowrap {{ request()->routeIs('catalyst-explorer.voter-tool') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                       href="{{localizeRoute('catalyst-explorer.voter-tool')}}">
                        Voter Tool
                    </a>
                </li>
                <li class="flow-root menu-item">
                    <a href="{{localizeRoute('catalyst-explorer.bookmarks')}}"
                       class="inline-flex items-center menu-link group">
                        <span class="relative z-0 inline-flex rounded-md shadow-sm" x-cloak>
                        <button type="button"
                                class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-pink-700 border border-pink-300 rounded-l-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                            <svg x-show="getBookmarkCount() > 0" class="w-5 h-5 mr-2 -ml-1 text-white"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path x-show="getBookmarkCount() > 0" d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                            </svg>
                            <svg x-show="getBookmarkCount() === 0" xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 mr-2 -ml-1 text-white"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <span class="hidden md:inline-block">Bookmarks</span>
                        </button>

                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
