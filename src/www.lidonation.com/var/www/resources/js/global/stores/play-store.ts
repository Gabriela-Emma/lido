import { defineStore } from "pinia";
import { computed, onMounted, ref, Ref, onUnmounted, onBeforeUnmount, watch } from "vue";
import Proposal from "@/apps/catalyst-explorer/models/proposal";
import Playlist from "@/global/models/playlist";
import { StorageSerializers, useStorage } from "@vueuse/core";


export const usePlayStore = defineStore('play-store', () => {
    let playList: Ref<Playlist[]> = useStorage('playList', [], localStorage, { mergeDefaults: true });
    let currentlyPlayingIndex: Ref<number> = useStorage('currentlyPlaying', 0, localStorage, { mergeDefaults: true });
    let showPlayer: Ref<boolean> = useStorage('showPlayer', false, localStorage, { mergeDefaults: true });
    let currentTimeSaved = ref(null);
    let playerInstance = ref(null);
    let currentTime = ref(null);
    let playing = ref(false);
    let duration = ref(0);
    let volume = ref(10);
    let muted = ref(false);
    let previousVolume = ref(null);
    let changingSource = ref(false);
    let waiting = ref(false);
    let dontRestart = ref(false);


    async function startPlaying(proposals: Proposal[]) {
        if (!proposals.length) { return };
        if (!showPlayer.value) {
            showPlayer.value = true;
            await makePlaylist(proposals);
            waiting.value = false;
            setTimeout(() => {
                createPlayer();
            }, 1500);
        }
    }

    async function makePlaylist(proposals: Proposal[]) {
        const regex = /[a-zA-Z]/g;
        playList.value = proposals
            .filter((item) => item.quickpitch)
            .map((item) => {
                const { title, quickpitch, id } = item;
                const provider = quickpitch?.match(regex) ? "youtube" : "vimeo";
                return { title, quickpitch, provider, id };
            });
    }

    async function createPlayer() {


        playerInstance.value.on('timeupdate', (event) => {
            const instance = event.detail.plyr;
            currentTime.value = instance.currentTime;
        });

        playerInstance.value.on('volumechange', (event) => {
            const instance = event.detail.plyr;
            volume.value = instance.volume;
        });

        playerInstance.value.on('play', (event) => {
            const instance = event.detail.plyr;

            playing.value = true;
        });

        playerInstance.value.on('pause', () => {
            playing.value = false;
        });

        playerInstance.value.on('ended', () => {
            currentlyPlayingIndex.value == (playList.value.length - 1) ?
                clearStore() :
                changeCurrentlyPlaying('next');

        });

        playerInstance.value.on('error', () => {
            changeCurrentlyPlaying('next');
        });

        playerInstance.value.on('stalled', () => {
            changeCurrentlyPlaying('next');
        });

        playerInstance.value.on('playing', (event) => {
            playing.value = true;

        });

        playerInstance.value.on('ready', (event) => {
            const instance = event.detail.plyr;
            playing.value = instance.playing
            duration.value = instance.duration;
            if (dontRestart.value) {
                playerInstance.value.forward(currentTimeSaved.value);
                instance.currentTime = currentTimeSaved.value;
                dontRestart.value = false;
            }else{
                playerInstance.value.play();
            }


        });

        playerInstance.value.source = {
            type: 'video',
            sources: [
                {
                    src: playList.value[currentlyPlayingIndex.value].quickpitch,
                    provider: playList.value[currentlyPlayingIndex.value].provider,
                },
            ],
        };

    }

    async function changeCurrentlyPlaying(direction) {
        if (changingSource.value) {
            return;
        }
        changingSource.value = true;
        waiting.value = true;
        playerInstance.value.pause();

        if (direction == 'next') {
            currentlyPlayingIndex.value = currentlyPlayingIndex.value + 1;
            if (currentlyPlayingIndex.value >= playList.value.length) {
                currentlyPlayingIndex.value = 0;
            }
        } else {
            currentlyPlayingIndex.value = currentlyPlayingIndex.value - 1;
            if (currentlyPlayingIndex.value < 0) {
                currentlyPlayingIndex.value = playList.value.length - 1;
            }
        }
        changingSource.value = false;
        setTimeout(() => {
            createPlayer()
        }, 1500);
        waiting.value = false
    }

    function formatTime(time: number ) {
        const date = new Date(time * 1000);

        const hours = String(date.getUTCHours()).padStart(2, '0');
        const minutes = String(date.getUTCMinutes()).padStart(2, '0');
        const seconds = String(date.getUTCSeconds()).padStart(2, '0');

        return `${hours}:${minutes}:${seconds}`;
    }

    function changeVolume() {
        playerInstance.value.volume = volume.value;
    }

    function scrub() {
        playerInstance.value.currentTime = currentTime.value;
    }

    function forward() {
        playerInstance.value.forward(10)
    }

    function rewind() {
        playerInstance.value.rewind(10)
    }

    async function toggle() {
        if (playing.value) {
            playerInstance.value.pause();
        } else {
            playerInstance.value.play();

        }
        return
    }

    function mute() {
        if (!playerInstance.value.muted) {
            previousVolume.value = playerInstance.value.volume
            playerInstance.value.muted = true
        } else {
            playerInstance.value.muted = false
            playerInstance.value.volume = previousVolume.value
        }
        muted.value = playerInstance.value.muted
    }

    function clearStore() {
        if (!playList.value.length && !showPlayer.value) return;
        showPlayer.value = false;
        playing.value = false;
        currentTime.value = 0;
        duration.value = 0;
        volume.value = 10;
        muted.value = false;
        currentlyPlayingIndex.value = 0;
        previousVolume.value = null;
        changingSource.value = false;
        waiting.value = false;
        playList.value = [];
        playerInstance.value = null;
        localStorage.removeItem('currentTimeSaved')
    }

    async function setPlayer(player) {
        if (playerInstance.value) return;
        playerInstance.value = player.player;
        createPlayer();
        toggle();
        waiting.value = false
    }


    let currentlyPlaying = computed(() => playList.value[currentlyPlayingIndex.value])
    const currentTimeFormatted = computed(() => formatTime(currentTime.value));
    const durationFormatted = computed(() => formatTime(duration.value));
    currentTimeSaved = computed<number>(() => {
        if (currentTime.value) {
            return currentTime.value
        }
        return parseInt(localStorage.getItem('currentTimeSaved'))
    });

    watch(
        currentTimeSaved,
        (newTime, oldTime) => {
            if (newTime) {
                localStorage.setItem('currentTimeSaved', newTime.toString());
            }
        },
        { deep: true },
    );

    onMounted(async () => {
        if (showPlayer && playList.value.length && currentTimeSaved.value) {
            waiting.value = true;
            dontRestart.value = true;
        }
    });

    return {
        currentTimeFormatted,
        durationFormatted,
        toggle,
        rewind,
        forward,
        scrub,
        changeVolume,
        volume,
        mute,
        changeCurrentlyPlaying,
        currentlyPlaying,
        muted,
        duration,
        playing,
        showPlayer,
        changingSource,
        setPlayer,
        clearStore,
        startPlaying,
        currentTime,
        waiting,
        currentlyPlayingIndex,
        currentTimeSaved,
        dontRestart,
        playList
    }
});
