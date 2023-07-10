<div class="sticky top-0 z-30 bg-teal-600 border-b border-teal-400 md:border-teal-light-300 page-nav">
    <div class='container relative'>
        <div class="flex flex-row justify-between gap-4 flex-nowrap">
            <nav class="flex max-w-[70%] overflow-x-auto" aria-label="Breadcrumb">
                <ol role="list" class="flex space-x-0">
                    @foreach($crumbs as $crumb)
                        @if($loop->first)
                            <li class="flex">
                                <div class="flex items-center">
                                    <a href="{{$crumb->link}}"
                                       class="flex flex-row items-center text-white hover:text-yellow-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                                        </svg>
                                        <span class="ml-1 text-xs font-medium sr-only">
                                            {{$crumb->label}}
                                        </span>
                                    </a>
                                </div>
                            </li>
                        @else
                            <li class="flex">
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 w-6 h-full text-teal-200" viewBox="0 0 24 44"
                                         preserveAspectRatio="none" fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                    </svg>
                                    @if($loop->last)
                                        <span class="inline-block ml-2 text-xs font-medium text-teal-light-100 whitespace-nowrap">
                                            {{$crumb->label}}
                                        </span>
                                    @else
                                        <a href="{{$crumb->link}}"
                                           class="inline-block ml-2 text-xs font-medium text-white hover:text-yellow-400 whitespace-nowrap">
                                            {{$crumb->label}}
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>

            <nav class="relative hidden xl:inline-flex">
                <ul class="flex flex-row items-center justify-end h-full gap-2 py-2 overflow-x-auto text-xs md:text-sm flex-nowrap">
                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.proposals') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('catalystExplorer.proposals')}}">
                            {{ $snippets->proposals }}
                        </a>
                    </li>

                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.people') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('catalystExplorer.people')}}">
                            {{ $snippets->people }}
                        </a>
                    </li>

                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.groups') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('catalystExplorer.groups')}}">
                            {{ $snippets->groups }}
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.reports') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('catalystExplorer.reports')}}">
                            {{ $snippets->reports }}
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.assessments') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('catalystExplorer.assessments')}}">
                            {{ $snippets->assessments }}
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('projectCatalyst.dashboard') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('projectCatalyst.dashboard')}}">
                            {{ $snippets->charts }}
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.votes.ccv4') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('projectCatalyst.votes.ccv4')}}">
                            {{ $snippets->votes }}
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                           href="/catalyst-explorer/api">
                            {{ $snippets->api }}
                        </a>
                    </li>
                     <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('catalystExplorer.funds') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('catalystExplorer.funds')}}">
                            {{ $snippets->funds }}
                        </a>
                    </li>

                    <li class="flow-root menu-item">
                        <a class="px-1 py-3 text-white menu-link whitespace-nowrap {{ request()->routeIs('catalystExplorer.voter-tool') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                           href="{{localizeRoute('projectCatalyst.voterTool')}}">
                            {{ $snippets->tool }}
                        </a>
                    </li>
                    <li class="flow-root menu-item"  x-data="bookmarksMenuLink">
                        <a href="{{localizeRoute('projectCatalyst.bookmarks')}}"
                           class="inline-flex items-center menu-link group">
                                <span class="relative z-0 inline-flex rounded-md shadow-sm" x-cloak>
                                    <button type="button"
                                            class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-pink-700 border border-pink-300 rounded-l-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                                        <svg x-show="getBookmarkCount() > 0"
                                             class="w-5 h-5 mr-2 -ml-1 text-white"
                                             xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path x-show="getBookmarkCount() > 0"
                                                  d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                        </svg>
                                        <svg x-show="getBookmarkCount() === 0"
                                             xmlns="http://www.w3.org/2000/svg"
                                             class="w-5 h-5 mr-2 -ml-1 text-white"
                                             fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span class="hidden md:inline-block">Bookmarks</span>
                                    </button>
                                    <button
                                        type="button"
                                        class="relative inline-flex items-center px-2 py-1 -ml-px text-sm font-medium text-white bg-white bg-pink-700 border border-pink-300 rounded-r-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                                    </button>
                                </span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="flex justify-center xl:hidden">
                <div
                    x-data="{
                        open: false,
                        toggle() {
                            if (this.open) {
                                return this.close()
                            }

                            this.$refs.button.focus()

                            this.open = true
                        },
                        close(focusAfter) {
                            if (! this.open) return

                            this.open = false

                            focusAfter && focusAfter.focus()
                        }
                    }"
                    x-on:keydown.escape.prevent.stop="close($refs.button)"
                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                    x-id="['dropdown-button']"
                    class="relative"
                >
                    <div class="flex flex-row items-center gap-2" x-data="bookmarksMenuLink">
                        <a href="{{localizeRoute('projectCatalyst.bookmarks')}}"
                           onclick='Livewire.emit("openModal", "catalyst.catalyst-voter-tool-bookmarks-component")'
                           class="inline-flex items-center menu-link group">
                                    <span class="relative z-0 inline-flex rounded-md shadow-sm" x-cloak>
                                    <button type="button"
                                            class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-pink-700 border border-pink-300 rounded-l-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                                        <svg x-show="getBookmarkCount() > 0" class="w-5 h-5 mr-2 -ml-1 text-white"
                                             xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path x-show="getBookmarkCount() > 0"
                                                  d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                        </svg>
                                        <svg x-show="getBookmarkCount() === 0" xmlns="http://www.w3.org/2000/svg"
                                             class="w-5 h-5 mr-2 -ml-1 text-white"
                                             fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span class="hidden lg:inline-block">Bookmarks</span>
                                    </button>
                                    <button
                                        type="button"
                                        class="relative inline-flex items-center px-2 py-1 -ml-px text-sm font-medium text-white bg-white bg-pink-700 border border-pink-300 rounded-r-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                                    </button>
                                    </span>
                        </a>

                        <button
                            x-ref="button"
                            x-on:click="toggle()"
                            :aria-expanded="open"
                            :aria-controls="$id('dropdown-button')"
                            type="button"
                            class="py-2.5 text-white hover:text-yellow-500"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute right-0 mt-2 overflow-hidden bg-white rounded shadow-md w-60"
                    >
                        <div class="divide-y divide-teal-300">
                            <a class="p-3 text-gray-500 menu-link block font-medium {{ request()->routeIs('projectCatalyst.reports') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('projectCatalyst.reports')}}">
                                {{ $snippets->reports }}
                            </a>
                            <a class="p-3 text-gray-500 menu-link block font-medium {{ request()->routeIs('projectCatalyst.dashboard') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('projectCatalyst.dashboard')}}">
                                {{ $snippets->charts }}
                            </a>

                            <a class="p-3 text-gray-500 menu-link block font-medium {{ request()->routeIs('projectCatalyst.funds') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('catalystExplorer.funds')}}">
                                {{ $snippets->funds }}
                            </a>

                            <a class="p-3 text-gray-500 menu-link block font-medium {{ request()->routeIs('catalystExplorer.proposals') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('catalystExplorer.proposals')}}">
                                {{ $snippets->projects }}
                            </a>
                            <a class="px-1 py-3 text-white menu-link {{ request()->routeIs('projectCatalyst.assessments') ? 'text-yellow-500' : '' }} hover:text-yellow-500"
                                href="{{localizeRoute('catalystExplorer.assessments')}}">
                                {{ $snippets->funds }}
                             </a>

                            <a class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                href="/catalyst-explorer/api">
                                {{ $snippets->api }}
                            </a>

                            <a class="p-3 text-gray-500 menu-link block font-medium {{ request()->routeIs('projectCatalyst.users') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('catalystExplorer.people')}}">
                                {{ $snippets->people }}
                            </a>

                            <a class="p-3 text-gray-500 menu-link block font-medium {{ request()->routeIs('projectCatalyst.groups') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('catalystExplorer.groups')}}">
                                {{ $snippets->groups }}
                            </a>

                            <a class="p-3 text-gray-500 menu-link block font-medium whitespace-nowrap {{ request()->routeIs('projectCatalyst.voterTool') ? 'text-teal-600' : '' }} hover:text-yellow-500"
                               href="{{localizeRoute('catalystExplorer.voter-tool')}}">
                                Voter Tool
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
