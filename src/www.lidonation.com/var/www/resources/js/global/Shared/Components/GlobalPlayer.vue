<template>
    <section
        class="sticky left-0 z-30 w-full bg-yellow-500 border-t border-yellow-600 -bottom-32 text-slate-800 drop-shadow-2xl">
        <div class="container relative py-4 overflow-visible">
            <div class="flex items-center gap-2">
                <div>
                    <button type="button" class="hover:text-white" @click="toggle">
                        <svg v-if="!playing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-20 h-20">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg v-if="!!playing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-20 h-20">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM9 8.25a.75.75 0 00-.75.75v6c0 .414.336.75.75.75h.75a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75H9zm5.25 0a.75.75 0 00-.75.75v6c0 .414.336.75.75.75H15a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75h-.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1">
                    <div class="font-medium">
                        EP1: 'd' Parameter
                    </div>
                    <div class="flex items-center gap-4">
                        <div>
                            <button type="button" class="" @click="rewind">
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
                            <button type="button" class="" @click="forward">
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
                            <input id="scrubber" type="range" min="0" :max="duration" v-model="currentTime" @change="scrub"
                                class="w-48 h-2 text-yellow-500 rounded-lg appearance-none cursor-pointer bg-slate-200 dark:bg-slate-700">
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path
                                    d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                                <path
                                    d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                            </svg>
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
                <div class="p-2 bg-yellow-500 border-t border-l border-r border-yellow-600 rounded-t-sm w-80" v-if="1">
                    <div class="embed-wrapper">
                        <div>
                            <div class="plyr__video-embed" id="player">
                                <iframe v-if="1"
                                    src="https://www.youtube.com/embed/bTqVqk7FSmY?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                                    allowfullscreen allowtransparency allow="autoplay">
                                </iframe>
                                <iframe v-if="0"
                                    src="https://player.vimeo.com/video/76979871?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                                    allowfullscreen allowtransparency allow="autoplay">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import Plyr from 'plyr';
const playing = ref(false);
const player = ref(null);
let currentTime = ref(0);
let duration = ref(0);
let volume = ref(10);
let padTo2Digits = (num) => {
    num.toString().padStart(2, '0');
}
const formatTime = (time) => new Date(time * 1000).toISOString().substr(14, 5);
const currentTimeFormatted = computed(() => formatTime(currentTime.value));
const durationFormatted = computed(() => formatTime(duration.value));
let changeVolume = () => {
    player.volume = volume.value / 10;
}
let scrub = (event) => {
    player.currentTime = event.target.value;
}
onMounted(() => {
    player.value = new Plyr('#player', {
        controls: [],
        volume: 1,
        muted: false,
        clickToPlay: false,
        autoplay: true,
        youtube: {
            rel: 0,
            autoplay: 1,
            enablejsapi: true,
            showinfo: false,
            playsinline: true,
            modestbranding: true
        }
    });
    player.value.on('timeupdate', (event) => {
        const instance = event.detail.plyr;
        currentTime.value = instance.currentTime;
        duration.value = instance.duration;
    });
    player.value.on('volumechange', (event) => {
        const instance = event.detail.plyr;
        volume.value = instance.volume * 10;
        console.log(volume.value);
    });
    player.value.on('play', () => {
        playing.value = true;
    });
    player.value.on('pause', () => {
        playing.value = false;
    });
});
let forward = () => {
    player.value.forward(10)
}
let rewind = () => {
    player.value.rewind(10)
}
function toggle() {
    if (playing.value) {
        player.value.pause();
    } else {
        player.value.play();
    }
}
</script>