<section x-data="globalVideoPlayer"  id="global-video-player-wrapper" @toggle-podcast.window="queueOrPauseContent($event)"
         class="fixed w-full left-0 -bottom-32 bg-yellow-500 text-slate-800 border-t border-yellow-600 z-30 drop-shadow-2xl">
    <div class="py-4 container relative overflow-visible">
        <div class="flex gap-2 items-center">
            <div>
                <button x-ref="globalVideoClicker" type="button" class="hover:text-white" @click="toggle">
                    <svg x-show="!playing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20">
                        <path fill-rule="evenodd"
                              d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z"
                              clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="!!playing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM9 8.25a.75.75 0 00-.75.75v6c0 .414.336.75.75.75h.75a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75H9zm5.25 0a.75.75 0 00-.75.75v6c0 .414.336.75.75.75H15a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75h-.75z" clip-rule="evenodd" />
                    </svg>

                </button>
            </div>

            <div class="flex-1">
                <div class="font-medium">
                    EP1: 'd' Parameter
                </div>
                <div class="flex gap-4 items-center">
                    <div>
                        <button type="button" class="" @click="rewind">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke-width="1.5"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 class="h-6 w-6 stroke-slate-800 group-hover:stroke-slate-400">
                                <path
                                    d="M8 5L5 8M5 8L8 11M5 8H13.5C16.5376 8 19 10.4624 19 13.5C19 15.4826 18.148 17.2202 17 18.188"></path>
                                <path d="M5 15V19"></path>
                                <path
                                    d="M8 18V16C8 15.4477 8.44772 15 9 15H10C10.5523 15 11 15.4477 11 16V18C11 18.5523 10.5523 19 10 19H9C8.44772 19 8 18.5523 8 18Z"></path>
                            </svg>
                        </button>
                        <button type="button" class="" @click="forward">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none"
                                 class="h-6 w-6 stroke-slate-800 group-hover:stroke-slate-400">
                                <path
                                    d="M16 5L19 8M19 8L16 11M19 8H10.5C7.46243 8 5 10.4624 5 13.5C5 15.4826 5.85204 17.2202 7 18.188"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M13 15V19" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                <path
                                    d="M16 18V16C16 15.4477 16.4477 15 17 15H18C18.5523 15 19 15.4477 19 16V18C19 18.5523 18.5523 19 18 19H17C16.4477 19 16 18.5523 16 18Z"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden flex-1 inline-flex gap-1 text-slate-800 text-sm ">
                        <label for="scrubber" class="mb-2 text-sm font-medium text-gray-900 dark:text-slate-600 sr-only">Player Scrubber</label>
                        <input id="scrubber" type="range" min="0" max="60" value="0"  x-ref="scrubber" x-transition
                               class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer dark:bg-slate-700 text-yellow-500">
                    </div>
                    <div class="inline-flex gap-1 text-slate-800 text-sm items-center">
                        <div><span x-ref="currentTime">0:00</span></div>
                        <div class="text-slate-400">/</div>
                        <div>~1:00</div>
                    </div>
                    <div class="inline-flex items-center">
                        <span class="inline-flex items-center hover:cursor-pointer hover:text-yellow-500 rounded-md bg-slate-800 px-1.5 py-0.5 text-xs font-medium text-slate-100">1x</span>
                    </div>
                    <div class="inline-flex items-center hover:cursor-pointer hover:text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                            <path d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="inline-flex items-end h-full self-baseline my-auto relative top-4 pt-1 hover:cursor-pointer hover:text-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                        <path d="M4.5 4.5a3 3 0 00-3 3v9a3 3 0 003 3h8.25a3 3 0 003-3v-9a3 3 0 00-3-3H4.5zM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="fixed right-0 bottom-0 overflow-visible" x-ref="globalVideoWrapper" x-transition :class="{
            'bottom-0 md:-bottom-60': loadingVideo,
            '-bottom-60': !loadingVideo,
        }">
            <div class="bg-yellow-500 w-80 p-2 border-r border-l border-t border-yellow-600 rounded-t-sm" x-transition>
                <video x-ref="globalVideo" id="globalVideo" playsinline class="bg-yellow-600" data-poster="{{asset('img/llogo-transparent.png')}}">
                    <source src="{{asset('videos/lido-logo.mp4')}}" type="video/mp4" />
                </video>
            </div>
        </div>
    </div>
</section>
