import { defineStore } from "pinia";
import Plyr from "plyr";
import { computed, onMounted, ref, Ref } from "vue";
import Proposal from "../../../catalyst-explorer/models/proposal";
import Playlist from "../Models/playlist";
import { useStorage } from "@vueuse/core";


export const usePlayStore = defineStore('play-store', () => {

    let playList: Ref<Playlist[]> = useStorage('playList', [], localStorage, { mergeDefaults: true });
    let showPlayer: Ref<Boolean> = useStorage('showPlayer', false, localStorage, { mergeDefaults: true });
    let playerInstance = useStorage('playerInstance', {} as Plyr, localStorage, { mergeDefaults: true });

    function startPlaying(proposals: Proposal[]) {
        console.log('wtf');
        
        if (!proposals.length) { return };
        console.log('wtf');
        if (!showPlayer.value) {
            playList.value = [
                {
                    "title": 'proposal3',
                    "provider": 'youtube',
                    "quickpitch": "QR33X9hs054",
                },
                {
                    "title": 'proposal2',
                    "provider": 'youtube',
                    "quickpitch": "mMRxVLBUtHY",
                },
                {
                    "title": 'proposal4',
                    "provider": 'youtube',
                    "quickpitch": "mMRxVLBUtHY",
                },


            ];

            createPlayer()
            console.log({ p: playList.value });
            showPlayer.value = true;
            // setTimeout(() => {
            //     playerInstance.value.source = {
            //         type: 'video',
            //         sources: [
            //             {
            //                 src: playList.value[0].quickpitch,
            //                 provider: playList.value[0].provider,
            //             },
            //         ],
            //     };
            // }, 200);

            // alert('tyty')
        } else {
            // makePlaylist(proposals);
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
        console.log(playList.value);
    }

    const plyr = ref(null)
    let show = ref(true);
    const playing = ref(false);
    // const player = ref(null);
    let currentTime = ref(0);
    let duration = ref(0);
    let volume = ref(10);
    let muted = ref(false);
    let currentlyPlayingIndex = ref(0);
    let previousVolume = ref(null);
    let changingSource = ref(false);
    let waiting = ref(false);

    // let playerInstance = ref(null)

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
            console.log(event.detail.plyr?.source);
            playing.value = true;
        });
        playerInstance.value.on('pause', () => {
            playing.value = false;
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
        console.log(playerInstance.value);
        if (changingSource.value) {
            return;
        }

        changingSource.value = true;
        let currentPlayer = plyr.value.player


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
        toggle()
        changingSource.value = false;
        console.log('change');
        playerInstance.value = plyr.value.player
        console.log(playerInstance.value);

        waiting.value = true
        createPlayer()
        setTimeout(() => {
            toggle();
        }, 1000);

        waiting.value = false
        console.log('gone');

    }


    function formatTime(time) {
        return new Date(time * 1000).toISOString().substr(14, 5);
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

    function toggle() {
        console.log(playerInstance.value);

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
    function clearStore(){
        show.value = false;
        playing.value = false;
        currentTime.value = 0;
        duration.value = 0;
        volume.value = 10;
        muted.value = false;
        currentlyPlayingIndex.value = 0;
        previousVolume.value = null;
        changingSource.value = false;
        waiting.value = false;
        playerInstance = null;
        playList.value = null;
    }


    let currentlyPlaying = computed(() => playList.value[currentlyPlayingIndex.value])
    const currentTimeFormatted = computed(() => formatTime(currentTime.value));
    const durationFormatted = computed(() => formatTime(duration.value));

    onMounted(async () => {
        playerInstance.value = plyr.value.player;
        console.log(playerInstance.value);
        createPlayer()

    });

    return {
        // currentTime,
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
        show,
        changingSource,
        playerInstance,
        plyr:plyr,
        clearStore,
        startPlaying
    }
});