<template>
    <TransitionRoot :show="true" enter="ease-out duration-700"
        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100"
        leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100"
        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <section v-if="showPlayer"
            class="w-full bg-yellow-500 border-t border-yellow-600 -bottom-32 text-slate-800 drop-shadow-2xl global-player">
            <div class="container flex flex-row items-center gap-4">
                <div class="p-0">
                    <div class="embed-wrapper">
                        <vue-plyr ref="plyr" id="#player">
                            <div id="player" :data-plyr-provider="currentlyPlaying?.provider"
                                :data-plyr-embed-id="currentlyPlaying?.quickpitch">
                            </div>
                        </vue-plyr>
                    </div>
                </div>

                <div class="relative py-2 overflow-visible">
                    <div class="flex flex-row items-start justify-start gap-3">
                        <div class="flex flex-col gap-1">
                            <div class="flex flex-row">
                                <button type="button" class="hover:text-white " :disabled="waiting"
                                    :class="{ 'cursor-not-allowed': waiting }"
                                    @click.prevent="playStore.changeCurrentlyPlaying('previous')">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                                        fill="currentColor" class="w-12 h-12 hover:fill-white fill-slate-700">
                                        <path
                                            d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10c5.515 0 10-4.486 10-10S17.515 2 12 2zm4 14-6-4v4H8V8h2v4l6-4v8z" />
                                    </svg>
                                </button>
                                <div role="status" v-if="waiting">
                                    <svg aria-hidden="true"
                                        class="inline w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-400"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill" />
                                    </svg>
                                </div>
                                <button v-if="!waiting" type="button" class="hover:text-white" @click.prevent="playStore.toggle()">
                                    <PlayCircleIcon v-if="!playing" class="w-12 h-12 text-slate-700 hover:text-white"
                                        :aria-hidden="true" />
                                    <PauseCircleIcon v-if="playing" class="w-12 h-12 text-slate-700 hover:text-white"
                                        :aria-hidden="true" />
                                </button>
                                <button class="hover:text-white" @click="playStore.clearStore()">
                                    <StopCircleIcon class="w-12 h-12 text-slate-700 hover:text-white" aria-hidden="true" />
                                </button>
                                <button type="button" class="hover:text-white" :disabled="waiting"
                                    :class="{ 'cursor-not-allowed': waiting }"
                                    @click.prevent="playStore.changeCurrentlyPlaying('next')">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                        id="mdi-skip-next-circle" fill="currentColor"
                                        class="w-12 h-12 fill-slate-700 hover:fill-white" viewBox="0 0 24 24">
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M8,8L13,12L8,16M14,8H16V16H14" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-3">
                                <div>
                                    <button type="button" class="" @click.prevent="playStore.rewind()">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="w-8 h-8 stroke-slate-800 group-hover:stroke-slate-400">
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
                                            class="w-8 h-8 stroke-slate-800 group-hover:stroke-slate-400">
                                            <path
                                                d="M16 5L19 8M19 8L16 11M19 8H10.5C7.46243 8 5 10.4624 5 13.5C5 15.4826 5.85204 17.2202 7 18.188"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M13 15V19" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                            <path
                                                d="M16 18V16C16 15.4477 16.4477 15 17 15H18C18.5523 15 19 15.4477 19 16V18C19 18.5523 18.5523 19 18 19H17C16.4477 19 16 18.5523 16 18Z"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- //@todo only show scrubber on extended view -->
                                <!-- <div class="inline-flex flex-1 gap-1 text-sm text-slate-800 ">
                                    <label for="scrubber"
                                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-slate-600">Player
                                        Scrubber</label>
                                    <input id="scrubber" type="range" min="0" :max="duration" @change="playStore.scrub()"
                                        v-model="currentTime">
                                </div> -->
                                <div class="inline-flex items-center gap-0.5 text-sm text-slate-800 plyr__controls__item plyr__time--current plyr__time">
                                    <div><span>{{ currentTimeFormatted }}</span></div>
                                    <div class="text-slate-400">/</div>
                                    <div>{{ durationFormatted }}</div>
                                </div>
                                <div class="inline-flex items-center">
                                    <span
                                        class="inline-flex items-center hover:cursor-pointer hover:text-yellow-500 rounded-md bg-slate-800 px-1.5 py-0.5 text-xs font-medium text-slate-100">1x</span>
                                </div>
                            </div>
                            <!-- <div class="w-full">
                                <div class="flex items-center w-full hover:cursor-pointer hover:text-slate-200">
                                    <button type="button" class="hover:text-white" @click="playStore.mute()">
                                        <SpeakerWaveIcon v-if="!muted" class="w-6 h-6" aria-hidden="true" />
                                        <SpeakerXMarkIcon v-if="!!muted" class="w-6 h-6" aria-hidden="true" />
                                    </button>
                                    <input id="volume-slider" class="text-slate-800" type="range" min="0" :max="1" step="0.01" v-model="volume"
                                        @change="playStore.changeVolume()">
                                </div>
                            </div> -->
                        </div>
                        <div class="flex-1 pt-1">
                            <div class="text-lg font-bold lg:text-xl">
                                {{ currentlyPlaying?.title }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </TransitionRoot>
</template>
<script setup lang="ts">
import {  PlayCircleIcon, PauseCircleIcon, } from '@heroicons/vue/24/solid';
import { usePlayStore } from '../store/play-store';
import { storeToRefs } from 'pinia';
import { ref, watch } from 'vue';
import { StopCircleIcon } from '@heroicons/vue/20/solid';
import { TransitionRoot } from "@headlessui/vue";

let plyr = ref(null);

const playStore = usePlayStore();
let { showPlayer } = storeToRefs(playStore);
let { playing } = storeToRefs(playStore);
let { currentlyPlaying } = storeToRefs(playStore);
let { waiting } = storeToRefs(playStore);
let { durationFormatted } = storeToRefs(playStore);
let { currentlyPlayingIndex } = storeToRefs(playStore);

let { currentTimeFormatted } = storeToRefs(playStore);

watch([plyr, currentlyPlayingIndex], async () => {
    if (plyr.value) {
        waiting.value = true;
        await playStore.setPlayer(plyr.value);
        playStore.toggle()
        setTimeout(() => {
            playStore.toggle()
            waiting.value = false;
        }, 3000);
    }
})
</script>
