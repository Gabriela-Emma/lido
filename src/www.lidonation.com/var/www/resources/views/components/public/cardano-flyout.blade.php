<div class="z-40 relative"
     x-data="cardanoMenu()"
     x-show="showing"
     x-cloak
     x-transition:enter="transition ease-out duration-100"
     x-transition:enter-start=" opacity-0 -translate-y-1 "
     x-transition:enter-end=" opacity-100 translate-y-0 "
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-1"
     x-on:toggle-cardano-menu.window="toggle()"
     x-on:show-cardano-menu.window="show()"
     x-on:hide-cardano-menu.window="hide()">
    <!--
      Flyout menu, show/hide based on flyout menu state.

      Entering: "transition ease-out duration-200"
        From: "opacity-0 -translate-y-1"
        To: "opacity-100 translate-y-0"
      Leaving: "transition ease-in duration-150"
        From: "opacity-100 translate-y-0"
        To: "opacity-0 -translate-y-1"
    -->
    <template x-if="showing">
        <div
            class="md:absolute z-10 inset-x-0 transform md:shadow-lg left-[-8rem] md:w-[26rem] lg:left-[-24rem] lg:w-[42rem] xl:w-[50rem] xl:left-[-32rem] top-2">
            <div class="md:absolute inset-0 flex" aria-hidden="true">
                <div class="bg-white w-1/2"></div>
                <div class="bg-gray-50 w-1/2"></div>
            </div>
            <div
                x-on:click.outside.window="hide()"
                class="relative max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-5 xl:grid-cols-3">
                <nav
                    class="col-span-2 xl:col-span-1 grid gap-y-10 px-4 py-8 bg-white sm:grid-cols-1 sm:gap-x-8 sm:py-12 sm:px-6 lg:px-8 xl:pr-12"
                    aria-labelledby="solutionsHeading">
                    <h2 class="sr-only">Cardano getting started menu</h2>
                    <div>
                        <h3 class="text-sm font-medium tracking-wide text-gray-500 uppercase">
                            Getting Started
                        </h3>
                        <ul class="mt-5 space-y-6 text-base font-medium">
                            <x-public.cardano-getting-started-links />
                        </ul>
                    </div>
                    {{--                <div>--}}
                    {{--                    <h3 class="text-sm font-medium tracking-wide text-gray-500 uppercase">--}}
                    {{--                        Resources--}}
                    {{--                    </h3>--}}
                    {{--                    <ul class="mt-5 space-y-6">--}}
                    {{--                        <li class="flow-root">--}}
                    {{--                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">--}}
                    {{--                                <!-- Heroicon name: outline/user-group -->--}}
                    {{--                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
                    {{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />--}}
                    {{--                                </svg>--}}
                    {{--                                <span class="ml-4">Community</span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}

                    {{--                        <li class="flow-root">--}}
                    {{--                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">--}}
                    {{--                                <!-- Heroicon name: outline/globe-alt -->--}}
                    {{--                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
                    {{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />--}}
                    {{--                                </svg>--}}
                    {{--                                <span class="ml-4">Partners</span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}

                    {{--                        <li class="flow-root">--}}
                    {{--                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">--}}
                    {{--                                <!-- Heroicon name: outline/bookmark-alt -->--}}
                    {{--                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
                    {{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />--}}
                    {{--                                </svg>--}}
                    {{--                                <span class="ml-4">Guides</span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}

                    {{--                        <li class="flow-root">--}}
                    {{--                            <a href="#" class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-50 transition ease-in-out duration-150">--}}
                    {{--                                <!-- Heroicon name: outline/desktop-computer -->--}}
                    {{--                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
                    {{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />--}}
                    {{--                                </svg>--}}
                    {{--                                <span class="ml-4">Webinars</span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                    </ul>--}}
                    {{--                </div>--}}
                </nav>
                @if($quickNews)
                    <div class="col-span-3 xl:col-span-2 bg-gray-50 px-4 py-8 sm:py-12 sm:px-6 lg:px-8 xl:pl-12">
                        <div>
                            <h3 class="text-sm font-medium tracking-wide text-gray-500 uppercase">
                                Cardano News
                            </h3>
                            <ul class="mt-6 space-y-6">
                                @foreach($quickNews->take(2) as $post)
                                    <li class="flow-root text-gray-500" x-data="{}">
                                        <span class="-m-3 p-3 flex flex-col rounded-sm hover:bg-gray-100 transition ease-in-out duration-150">
                                            <span class="flex {{$direction ?? 'flex-row'}} gap-8 items-center">
                                                @if($post->hero)
                                                    <span class="block flex-shrink-0">
                                                        <a href="{{$post->link}}">
                                                            <img class="w-32 h-20 object-cover rounded-tl-[7rem] rounded-tr-[5rem] rounded-br-[4rem] rounded-bl-[0.5rem] bg-teal-600 filter hover:contrast-200 "
                                                                 srcset="{{$post->hero?->getSrcset('thumbnail')}}"
                                                                 src="{{$post->hero?->getUrl('thumbnail')}}"
                                                                 alt="{{$post->hero?->name}}" />
                                                        </a>
                                                    </span>
                                                @endif
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex flex-row mb-1">
                                                        @if($post->categories->isNotEmpty())
                                                            <x-public.post-taxonomies textColor="text-white" :tax="$post->categories->first()"></x-public.post-taxonomies>
                                                        @endif
                                                    </div>
                                                    <h3 class="font-medium text-black line-clamp-1 xl:line-clamp-2">
                                                        <a href="{{$post->link}}">
                                                            {{$post->title}}
                                                        </a>
                                                    </h3>

                                                    <div class="">
                                                        <x-public.post-meta :post="$post"></x-public.post-meta>
                                                    </div>
                                                </div>
                                            </span>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-8 text-sm font-medium relative top-2">
                            <x-public.continue-reading text="Cardano & Crypto News" route='news'></x-public.continue-reading>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </template>
</div>
