import { defineStore } from "pinia";
import { computed, onMounted, ref, Ref } from "vue";
import Proposal from "../../../catalyst-explorer/models/proposal";
import Playlist from "../Models/playlist";
import { useStorage } from "@vueuse/core";


export const usePlayStore = defineStore('play-store', () => {
    let playList: Ref<Playlist[]> = useStorage('playList', [], localStorage, { mergeDefaults: true });
    let currentlyPlayingIndex: Ref<number> = useStorage('currentlyPlaying', 0, localStorage, { mergeDefaults: true });
    let showPlayer: Ref<boolean> = useStorage('showPlayer', false, localStorage, { mergeDefaults: true });
    let playerInstance = ref(null);
    let playing = ref(false);
    let currentTime = ref(0);
    let duration = ref(0);
    let volume = ref(10);
    let muted = ref(false);
    let previousVolume = ref(null);
    let changingSource = ref(false);
    let waiting = ref(false);

    async function startPlaying(proposals: Proposal[]) {
        if (!proposals.length) { return };
        if (!showPlayer.value) {
            showPlayer.value = true;
            await makePlaylist(proposals);
            waiting.value = false;
            setTimeout(() => {
                createPlayer();
                toggle();
            }, 1000);
        }
    }

    async function makePlaylist(proposals: Proposal[]) {
        const regex = /[a-zA-Z]/g;
        playList.value = proposals
            .filter((item) => item.quickpitch)
            .map((item) => {
                const { title, quickpitch } = item;
                const provider = quickpitch?.match(regex) ? "youtube" : "vimeo";
                return { title, quickpitch, provider };
            });
    }

    async function createPlayer() {
        playerInstance.value.on('timeupdate', (event) => {
            const instance = event.detail.plyr;
            currentTime.value = instance.currentTime;
            duration.value = instance.duration;
        });
        playerInstance.value.on('volumechange', (event) => {
            const instance = event.detail.plyr;
            volume.value = instance.volume;
        });
        playerInstance.value.on('play', (event) => {
            playing.value = true;
        });
        playerInstance.value.on('pause', () => {
            playing.value = false;
        });

        playerInstance.value.on('ended', () => {
            changeCurrentlyPlaying('next');
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
            playerInstance.value.play()

        }, 1000);
        waiting.value = false
    }

    function formatTime(time) {
        const date = new Date(time * 1000);
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        return `${minutes}:${seconds}`;
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
        playerInstance.value = null
    }

    async function setPlayer(player) {
        if (playerInstance.value) { return };
        playerInstance.value = player.player;
        createPlayer();
        toggle();
        waiting.value = false
    }


    let currentlyPlaying = computed(() => playList.value[currentlyPlayingIndex.value])
    const currentTimeFormatted = computed(() => formatTime(currentTime.value));
    const durationFormatted = computed(() => formatTime(duration.value));


    onMounted(async () => {
        if (showPlayer && playList.value.length) {
            waiting.value = true
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
    }
});
