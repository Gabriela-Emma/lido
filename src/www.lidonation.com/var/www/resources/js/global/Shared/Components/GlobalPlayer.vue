<template>
    <section v-if="show"
        class="sticky left-0 z-30 w-full bg-yellow-500 border-t border-yellow-600 -bottom-32 text-slate-800 drop-shadow-2xl">
        <div class="container relative py-4 overflow-visible">
            <div class="flex items-center gap-2">
                <div class="flex flex-row">
                    <button type="button" class="hover:text-white" :disabled="changingSource"
                        @click.prevent="playStore.changeCurrentlyPlaying('previous')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                            fill="currentColor" class="w-20 h-20 hover:fill-white fill-slate-700">
                            <path
                                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10c5.515 0 10-4.486 10-10S17.515 2 12 2zm4 14-6-4v4H8V8h2v4l6-4v8z" />
                        </svg>
                    </button>
                    <button type="button" class="hover:text-white" @click.prevent="playStore.toggle()" :disabled="changingSource">
                        <PlayCircleIcon v-if="!playing" class="w-20 h-20 text-slate-700" aria-hidden="true" />
                        <PauseCircleIcon v-if="!!playing" class="w-20 h-20 text-slate-700" aria-hidden="true" />
                    </button>
                    <button type="button" class="hover:text-white"
                        @click.prevent="playStore.changeCurrentlyPlaying('next')">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                            id="mdi-skip-next-circle" fill="currentColor" class="w-20 h-20 fill-slate-700 hover:fill-white"
                            viewBox="0 0 24 24">
                            <path
                                d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M8,8L13,12L8,16M14,8H16V16H14" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1">
                    <div class="font-medium">
                        {{ currentlyPlaying.title }}
                    </div>
                    <div class="flex items-center gap-4">
                        <div>
                            <button type="button" class="" @click.prevent="playStore.rewind()">
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="w-6 h-6 stroke-slate-800 group-hover:stroke-slate-400">
                                    <path
                                        d="M8 5L5 8M5 8L8 11M5 8H13.5C16.5376 8 19 10.4624 19 13.5C19 15.4826 18.148 17.2202 17 18.188">
                                    </path>
                                    <path d="M5 15V19"></path>
                                    <path
                                        d="M8 18V16C8 15.4477 8.44772 15 9 15H10C10.5523 15 11 15.4477 11 16V18C11 18.5523 10.5523 19 10 19H9C8.44772 19 8 18.5523 8 18Z">
                                    </path>
                                </svg>
                            </button>
                            <button type="button" class="" @click="playStore.forward()">
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none"
                                    class="w-6 h-6 stroke-slate-800 group-hover:stroke-slate-400">
                                    <path
                                        d="M16 5L19 8M19 8L16 11M19 8H10.5C7.46243 8 5 10.4624 5 13.5C5 15.4826 5.85204 17.2202 7 18.188"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M13 15V19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path
                                        d="M16 18V16C16 15.4477 16.4477 15 17 15H18C18.5523 15 19 15.4477 19 16V18C19 18.5523 18.5523 19 18 19H17C16.4477 19 16 18.5523 16 18Z"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="inline-flex flex-1 gap-1 text-sm text-slate-800 ">
                            <label for="scrubber"
                                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-slate-600">Player
                                Scrubber</label>
                            <input id="scrubber" type="range" min="0" :max="duration" v-model="currentTime"
                                @change="playStore.scrub()">
                        </div>
                        <div class="inline-flex items-center gap-1 text-sm text-slate-800">
                            <div><span>{{ currentTimeFormatted }}</span></div>
                            <div class="text-slate-400">/</div>
                            <div>~{{ durationFormatted }}</div>
                        </div>
                        <div class="inline-flex items-center">
                            <span
                                class="inline-flex items-center hover:cursor-pointer hover:text-yellow-500 rounded-md bg-slate-800 px-1.5 py-0.5 text-xs font-medium text-slate-100">1x</span>
                        </div>
                        <div class="inline-flex items-center hover:cursor-pointer hover:text-slate-200">
                            <button type="button" class="hover:text-white" @click="playStore.mute()">
                                <SpeakerWaveIcon v-if="!muted" class="w-6 h-6" aria-hidden="true" />
                                <SpeakerXMarkIcon v-if="!!muted" class="w-6 h-6" aria-hidden="true" />
                            </button>
                            <input id="volume-slider" type="range" min="0" :max="1" step="0.01" v-model="volume"
                                @change="playStore.changeVolume()">
                        </div>
                    </div>
                </div>
                <div class="">
                    <div
                        class="relative inline-flex items-end h-full pt-1 my-auto self-baseline top-4 hover:cursor-pointer hover:text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                            <path
                                d="M4.5 4.5a3 3 0 00-3 3v9a3 3 0 003 3h8.25a3 3 0 003-3v-9a3 3 0 00-3-3H4.5zM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="fixed bottom-0 right-0 overflow-visible" :class="{
                'bottom-0 md:-bottom-60': 1,
                '-bottom-60': !1,
            }">
                <div class="p-2 bg-yellow-500 border-t border-l border-r border-yellow-600 rounded-t-sm w-80">
                    <div class="embed-wrapper">
                        <div>
                            <vue-plyr ref="player" v-if="currentlyPlaying.provider === 'youtube'">
                                <div :data-plyr-provider="currentlyPlaying.provider" :data-plyr-embed-id="currentlyPlaying.playId">
                                </div>
                            </vue-plyr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup lang="ts">
import { SpeakerXMarkIcon, SpeakerWaveIcon, PlayCircleIcon, PauseCircleIcon, } from '@heroicons/vue/24/solid';
import { usePlayStore } from '../store/play-store';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';




const playStore = usePlayStore();
let { show } = storeToRefs(playStore);
let { playing } = storeToRefs(playStore);
let { currentlyPlaying } = storeToRefs(playStore);
let { muted } = storeToRefs(playStore);
let { volume } = storeToRefs(playStore);
let { duration } = storeToRefs(playStore);
let { currentTime } = storeToRefs(playStore);
let { durationFormatted } = storeToRefs(playStore);
let { currentTimeFormatted } = storeToRefs(playStore);
let { changingSource } = storeToRefs(playStore);
let {plyr:player} = storeToRefs(playStore);

console.log(player);


</script>