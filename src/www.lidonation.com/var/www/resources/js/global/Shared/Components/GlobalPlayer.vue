<template>
    <section
        class="sticky left-0 z-30 w-full bg-yellow-500 border-t border-yellow-600 -bottom-32 text-slate-800 drop-shadow-2xl">
        <div class="container relative py-4 overflow-visible">
            <div class="flex items-center gap-2">
                <div class="flex flex-row">
                    <button type="button" class="hover:text-white" @click="changeCurrentlyPlaying('previous')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                            fill="currentColor" class="w-20 h-20 hover:fill-white fill-slate-700">
                            <path
                                d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10c5.515 0 10-4.486 10-10S17.515 2 12 2zm4 14-6-4v4H8V8h2v4l6-4v8z" />
                        </svg>
                    </button>
                    <button type="button" class="hover:text-white" @click="toggle">
                        <PlayCircleIcon v-if="!playing" class="w-20 h-20 text-slate-700" aria-hidden="true" />
                        <PauseCircleIcon v-if="!!playing" class="w-20 h-20 text-slate-700" aria-hidden="true" />
                    </button>
                    <button type="button" class="hover:text-white" @click="changeCurrentlyPlaying('next')">
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
                            <input id="scrubber" type="range" min="0" :max="duration" v-model="currentTime" @change="scrub">
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
                            <button type="button" class="hover:text-white" @click="mute">
                                <SpeakerWaveIcon v-if="!muted" class="w-6 h-6" aria-hidden="true" />
                                <SpeakerXMarkIcon v-if="!!muted" class="w-6 h-6" aria-hidden="true" />
                            </button>
                            <input id="volume-slider" type="range" min="0" :max="1" step="0.01" v-model="volume"
                                @change="changeVolume">
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
                            <div class="plyr__video-embed" id="player">
                                <iframe v-if="currentlyPlaying.provider == 'youtube'" :src="currentlyPlaying.link"
                                    allowfullscreen allowtransparency allow="autoplay">
                                </iframe>
                                <iframe v-if="currentlyPlaying.provider == 'vimeo'" :src="currentlyPlaying.link"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
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
import { SpeakerXMarkIcon, SpeakerWaveIcon, PlayCircleIcon, PauseCircleIcon, } from '@heroicons/vue/24/solid';
import Plyr from 'plyr';

onMounted(() => {
    createPlayer()
    player.value.source = {
        type: 'video',
        sources: [
            {
                src: currentlyPlaying.value.link,
                provider: currentlyPlaying.value.provider,
            },
        ],
    };
});
const playing = ref(false);
const player = ref(null);
let currentTime = ref(0);
let duration = ref(0);
let volume = ref(10);
let muted = ref(false);


let Playlist = [
    // {
    //     "title":'proposal1',
    //     "provider":'vimeo',
    //     "link":"https://vimeo.com/576882227",
    //     "playId":'576882227'
    // },
    {
        "title": 'proposal2',
        "provider": 'youtube',
        "link": "https://www.youtube.com/watch?v=mMRxVLBUtHY&start=37072",
        "playId": 'bTqVqk7FSmY'
    },
    {
        "title": 'proposal3',
        "provider": 'vimeo',
        "link": "https://vimeo.com/587825954",
        "playId": '76979871'
    },
    {
        "title": 'proposal4',
        "provider": 'youtube',
        "link": "https://www.youtube.com/watch?v=rMo9ExWv0mo",
        "playId": 'rMo9ExWv0mo'
    },
]

let currentlyPlayingIndex = ref(0)
let currentlyPlaying = computed(() => Playlist[currentlyPlayingIndex.value])
let changeCurrentlyPlaying = (direction) => {
    if (direction == 'next') {
        currentlyPlayingIndex.value = currentlyPlayingIndex.value + 1;
        if (currentlyPlayingIndex.value >= Playlist.length) {
            currentlyPlayingIndex.value = 0;
        }
    } else {
        currentlyPlayingIndex.value = currentlyPlayingIndex.value - 1;
        if (currentlyPlayingIndex.value < 0) {
            currentlyPlayingIndex.value = Playlist.length - 1;
        }
    }
    player.value.source = {
        type: 'video',
        sources: [
            {
                src: currentlyPlaying.value.link,
                provider: currentlyPlaying.value.provider,
            },
        ],
    };
    console.log(currentlyPlayingIndex.value);

}

const regex: RegExp = /[a-zA-Z]/g;
const quickPitchId = currentlyPlaying.value.link;
const quickpitchProvider = computed(() => quickPitchId.match(regex) ? "youtube" : "vimeo");


const formatTime = (time) => new Date(time * 1000).toISOString().substr(14, 5);
const currentTimeFormatted = computed(() => formatTime(currentTime.value));
const durationFormatted = computed(() => formatTime(duration.value));
let changeVolume = () => {
    player.value.volume = volume.value;
}
let scrub = (event) => {
    player.value.currentTime = currentTime.value;
}

let createPlayer = () => {
    player.value = new Plyr('#player', {
        controls: [],
        volume: 1,
        muted: false,
        clickToPlay: false,
        autoplay: false,
    });

    player.value.on('timeupdate', (event) => {
        const instance = event.detail.plyr;
        currentTime.value = instance.currentTime;
        duration.value = instance.duration;
    });
    player.value.on('volumechange', (event) => {
        const instance = event.detail.plyr;
        volume.value = instance.volume;
    });
    player.value.on('play', () => {
        playing.value = true;
    });
    player.value.on('pause', () => {
        playing.value = false;
    });


}


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

let previousVolume = ref(null);
function mute() {
    if (player.value.volume) {
        previousVolume.value = volume.value
        player.value.volume = 0
        muted.value = true
    } else {
        player.value.volume = previousVolume.value
        muted.value = false
    }

}
</script>