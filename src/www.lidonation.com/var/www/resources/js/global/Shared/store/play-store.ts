import { defineStore } from "pinia";
import Plyr from "plyr";
import { computed, onMounted, ref, Ref } from "vue";


export const usePlayStore = defineStore('play-store', () => {

    let playList = ref([
        {
            "title": 'proposal2',
            "provider": 'youtube',
            "link": "https://www.youtube.com/watch?v=mMRxVLBUtHY&start=37072",
            "playId": 'bTqVqk7FSmY'
        },
        // {
        //     "title": 'proposal3',
        //     "provider": 'vimeo',
        //     "link": "https://vimeo.com/587825954",
        //     "playId": '76979871'
        // },

        {
            "title": 'proposal4',
            "provider": 'youtube',
            "link": "https://www.youtube.com/watch?v=rMo9ExWv0mo",
            "playId": 'rMo9ExWv0mo'
        },
    ]);
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


    function createPlayer() {
        plyr.value.player.on('timeupdate', (event) => {
            const instance = event.detail.plyr;
            currentTime.value = instance.currentTime;
            duration.value = instance.duration;
        });
        plyr.value.player.on('volumechange', (event) => {
            const instance = event.detail.plyr;
            volume.value = instance.volume;
        });
        plyr.value.player.on('play', (event) => {
            
            console.log(event.detail.plyr?.source);
            playing.value = true;
        });
        plyr.value.player.on('pause', () => {
            playing.value = false;
        });


    }

    async function changeCurrentlyPlaying(direction) {
        if(changingSource.value){
            return;
        }

        changingSource.value = true;

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
        // createplyr()
        plyr.value.player.on('ready', () =>{
            plyr.value.player.source = {
                type: 'video',
                sources: [
                    {
                        src: currentlyPlaying.value.link,
                        provider: currentlyPlaying.value.provider,
                    },
                ],
            };
        })
     


    }

    function formatTime(time) {
        return new Date(time * 1000).toISOString().substr(14, 5);
    }

    function changeVolume() {
        plyr.value.volume = volume.value;
    }
    function scrub() {
        plyr.value.currentTime = currentTime.value;
    }

    function forward() {
        plyr.value.player.forward(10)
    }
    function rewind() {
        plyr.value.player.rewind(10)
    }
    function toggle() {
        console.log('tyty');

        if (playing.value) {
            plyr.value.player.pause();
        } else {
            plyr.value.player.play();
        }
        return
    }

    function mute() {
        if (plyr.value.volume) {
            previousVolume.value = volume.value
            plyr.value.player.volume = 0
            muted.value = true
        } else {
            plyr.value.player.volume = previousVolume.value
            muted.value = false
        }

    }


   
    let currentlyPlaying = computed(() => playList.value[currentlyPlayingIndex.value])
    const currentTimeFormatted = computed(() => formatTime(currentTime.value));
    const durationFormatted = computed(() => formatTime(duration.value));

    onMounted(async () => {
         createPlayer()
        // player.value.on('ready', () =>{
        //     player.value.source = {
        //         type: 'video',
        //         sources: [
        //             {
        //                 src: currentlyPlaying.value.link,
        //                 provider: currentlyPlaying.value.provider,
        //             },
        //         ],
        //     };
        // })
    });

    return {
        currentTime,
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
        plyr:plyr
    }
});