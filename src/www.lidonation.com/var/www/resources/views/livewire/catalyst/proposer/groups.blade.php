<div class="relative z-10 catalyst-proposals-research-wrapper">
    @livewire('catalyst.catalyst-sub-menu-component')

    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-20 flex flex-col block gap-3 sm:flex-row">
                <span class='z-20 font-light'>{{__('Catalyst') }}</span>
                <span class='z-20 font-black text-teal-600'>{{__('Groups') }}</span>
            </span>
        </x-slot>
        <h2 class="font-medium">
            {{ $snippets->prePayingForFutureInnovations}}
        </h2>

        @if($snippets)
            <x-markdown>{{$snippets[0]?->content}}</x-markdown>
        @endif
    </x-public.page-header>

    <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row items-center gap-4">
                <x-catalyst.groups.stats
                    :usersCount="$catalystGroupsCount"></x-catalyst.groups.stats>
            </div>
        </div>
    </section>

    <section class="relative bg-white py-16">
        <div class="container" x-data="{showPane: false}">
            <div class="space-y-12 relative">
                <div class="bg-white/[0.98] w-full h-full absolute z-30 space-y-4" x-show="showPane" x-transition>
                    <div class="flex flex-row justify-between gap-3 items-center">
                        <h2 class="xl:text-5xl">
                            How is this data calculated?
                        </h2>

                        <button
                            @click="showPane = !showPane"
                            type="button"
                            class="inline-flex items-center border px-4 py-1.5 border gap-1 text-md font-medium rounded-xs bg-transparent hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                        >
                            Close
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <div class="text-xl xl:text-2xl 2xl:text-3xl">
                        <b class="text-3xl mb-2">Two Simple Steps:</b>

                        <ol class="list-decimal flex flex-col gap-4 list-inside">
                            <li class="list-item">
                                A human at Lido Nation manually comb through proposals 2 identify <b>core</b> members of a group. People
                                denoted as such are listed on the group page.
                            </li>
                            <li class="list-item">
                                For these <b>core</b> member, a script finds all the proposals for which they are the
                                primary author & attribute that proposal to the group.
                            </li>
                        </ol>
                    </div>

                    <div class="text-center pt-10">
                        <p>
                            Despite our best efforts to maintain the accuracy of the the information presented here, inconsistencies may exist.
                        </p>
                        <p>Questions or feedback about this data?</p>
                        <a href="{{localizeRoute('community')}}#send-a-message">Send us a message </a>
                    </div>
                </div>

                <div
                    wire:loading.class.remove="hidden" wire:loading.delay.shortest.class="absolute"
                    class=" hidden top-0 left-0 z-10 flex items-center justify-center w-full h-full  bg-white-100 absolute  space-y-4">
                    <div
                        class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                        <svg
                            class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"
                            viewBox="0 0 24 24"></svg>
                    </div>
                </div>

                <div class="flex flex-row flex-wrap justify-between items-end">
                    <div class="space-y-5 sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
                        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                            Groups and Companies in Catalyst
                        </h2>
                        <p class="text-xl text-gray-500">
                            Teams bootstrapped by or received significant funding from Catalyst.
                        </p>
                    </div>

                    <div>
                        <div class="relative p-2 mb-2 border" x-data="{
                            sortBy: @entangle('sortBy'),
                            sortOrder: @entangle('sortOrder')
                        }">
                            <div
                                class="relative inline-block px-2 text-xs font-medium text-gray-600 bg-white 2xl:text-sm -top-6">
                                Sorts & Filters
                            </div>
                            <div class="flex flex-row flex-wrap gap-2 -mt-5 font-semibold">
                                <button
                                    wire:click="sortBy('slug')"
                                    type="button"
                                    class="inline-flex items-center px-2.5 py-0.5 border rounded-sm text-sm font-medium  hover:bg-teal-100"
                                    :class="{
                                        'bg-teal-300 text-white border-teal-400': sortBy === 'slug'
                                    }">
                                    <span x-show="sortBy === 'slug'" x-cloak>
                                        <svg x-show="sortOrder === 'asc'"
                                             class="-ml-0.5 mr-1.5 h-4 w-4 "
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                                        </svg>
                                        <svg x-show="sortOrder === 'desc'"
                                             xmlns="http://www.w3.org/2000/svg"
                                             class="-ml-0.5 mr-1.5 h-4 w-4"
                                             fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                                        </svg>
                                    </span>
                                    <template x-if="sortBy === 'none'">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-200"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                        </svg>
                                    </template>
                                    Alphabetically
                                </button>

                                <button
                                    wire:click="sortBy('amount_awarded')"
                                    type="button"
                                    class="inline-flex items-center px-2.5 py-0.5 border rounded-sm text-sm font-medium text-gray-600 hover:bg-teal-100 hover:text-white"
                                    :class="{
                                        'bg-teal-300 text-white border-teal-400': sortBy === 'amount_awarded'
                                    }" >
                                    <span x-show="sortBy === 'amount_awarded'" x-cloak>
                                        <svg x-show="sortOrder === 'asc'"
                                             class="-ml-0.5 mr-1.5 h-4 w-4 "
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                                        </svg>
                                        <svg x-show="sortOrder === 'desc'"
                                             xmlns="http://www.w3.org/2000/svg"
                                             class="-ml-0.5 mr-1.5 h-4 w-4 "
                                             fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                                        </svg>
                                    </span>

                                    <template x-if="sortBy === 'none'">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-200"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                        </svg>
                                    </template>
                                    $$ Awarded
                                </button>

                                <span
                                    class="inline-flex ml-4 xl:ml-8 2xl:ml-16 text-sm italic font-medium hover:cursor-pointer hover:text-teal-600"
                                    @click="@this.set('sortBy', 'slug'); @this.set('sortOrder', 'asc');">Reset</span>

                            </div>
                        </div>

                        <div
                            @click="showPane = !showPane"
                            class="text-teal-600 hover:cursor-pointer hover:text-yellow-800 text-sm font-semibold text-right ml-auto">
                            How is this data calculated?
                        </div>
                    </div>
                </div>
                <ul role="list"
                    class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-8">
                    @foreach($catalystGroups as $catalystGroup)
                        <li class="py-8 px-6 bg-primary-10 text-center rounded-sm flex flex-row justify-center xl:px-8 xl:text-left">
                            <div class="space-y-6 flex flex-col justify-between w-full xl:space-y-10">
                                <a href="{{$catalystGroup->link}}"
                                   class="w-32 h-32 lg:w-32 lg:h-32 xl:w-44 xl:h-44 rounded-full mx-auto shadow-inner shadow-md">
                                    <img class="rounded-full w-full h-full"
                                         src="{{$catalystGroup->thumbnail_url ?? $catalystGroup->gravatar}}"
                                         alt="{{$catalystGroup->name}} logo"/>
                                </a>
                                <div class="space-y-2 w-full xl:flex xl:items-center xl:justify-between items-end">
                                    <div class="font-medium text-lg leading-6 space-y-1">
                                        <h3 class="">
                                            <a href="{{$catalystGroup->link}}"
                                               class="text-gray-800 hover:text-teal-700">
                                                {{$catalystGroup->name}}
                                            </a>
                                        </h3>
                                        <div class="flex flex-col gap2 itemscenter justify-center">
                                            <span class="text-teal-600 font-semibold text-xl">
                                                ${{humanNumber($catalystGroup->amount_awarded)}}
                                            </span>
                                            <span class="text-gray-500 text-xs">Awarded</span>
                                        </div>
                                    </div>

                                    <ul role="list"
                                        class="flex justify-start items-center flex-wrap max-w-xs space-x-2 relative xl:top-4">
                                        @if(!!$catalystGroup->twitter)
                                            <li>
                                                <a href="https://twitter.com/{{Str::replace('@', '',$catalystGroup->twitter)}}"
                                                   target="_blank"
                                                   class="text-gray-400 hover:text-gray-300">
                                                    <span class="sr-only">Twitter</span>
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                         aria-hidden="true">
                                                        <path
                                                            d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(!!$catalystGroup->discord)
                                            <li>
                                                <a href="{{$catalystGroup->discord}}"
                                                   target="_blank"
                                                   class="text-gray-400 hover:text-gray-300">
                                                    <span class="sr-only">Discord Server Url</span>
                                                    <svg role="img" viewBox="0 0 24 24" stroke="currentColor"
                                                         class="h-5 w-5" fill="none">
                                                        <path
                                                            d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(!!$catalystGroup->website)
                                            <li>
                                                <a href="{{$catalystGroup->website}}" target="_blank"
                                                   class="text-gray-400 hover:text-gray-300">
                                                    <span class="sr-only">Website</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(!!$catalystGroup->github)
                                            <li>
                                                <a href="{{$catalystGroup->github}}" target="_blank"
                                                   class="text-gray-400 hover:text-gray-300">
                                                    <span class="sr-only">Github</span>
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6 paginator ">
                {{ $this->getPaginator()?->links() }}
            </div>
        </div>
    </section>
</div>
