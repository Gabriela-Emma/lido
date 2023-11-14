import Plyr from "plyr";
export default function globalVideoPlayer(this: any) {
    return {
        showVideo: true,
        paused: null,
        playing: null,
        queued: null,
        player: null,
        noRestart: true,
        playlist: [],
        loadingVideo: false,
        maximize: false,
        showPlayList: false,
        currentlyPlayingIndex: 0,
        nextPlay: null,
        currentPlayTime: 0, // this.$persist(0).using(localStorage).as('currentPlayTime'),
        loading: null,
        playingPodcast: null, //this.$persist([]).using(localStorage),
        init() {
            if (!this.player) {
                this.player = new Plyr(this.$refs.globalVideo, {
                    controls: ['mute', 'volume', 'fullscreen'],
                    volume: 1,
                    muted: false,
                    clickToPlay: false,
                    autoplay: true,
                    displayDuration: false,
                    youtube: {
                        rel: 0,
                        autoplay: 1,
                        enablejsapi: true,
                        showinfo: false,
                        playsinline: true,
                        modestbranding: true
                    }
                });
                // this.currentPlayTime ? this.noRestart = false : false;
                this.playerEvents();
            }
        },
        setCurrentPlaying()
        {
            this.playingPodcast = this.playlist[this.currentlyPlayingIndex]
        },
        queueOrPauseContent(event: string) {
            if (
                !this.playing?.includes(event) &&
                !this.pause?.includes(event)) {
                this.player.source = {
                    type: 'video',
                    sources: [
                        {
                            src: event,
                            provider: 'youtube',
                        },
                    ],
                };
                this.playingPodcast = this.playlist.find((item) => item.youtube_id == event);
                this.currentlyPlayingIndex = this.playlist.findIndex((item) => item.youtube_id == event);

                this.loadingVideo = true;
                this.$nextTick(() => {
                    this.player.play();
                    this.loadingVideo = false;
                });

            } else {
                this.toggle();
            }
        },
        rewind() {
            this.player.rewind(10);
        },
        forward() {
            this.player.forward(10);
        },
        toggle() {
            this.player.togglePlay();
        },
        formatTime(time: number) {
            const date = new Date(time * 1000);

            const hours = String(date.getUTCHours()).padStart(2, '0');
            const minutes = String(date.getUTCMinutes()).padStart(2, '0');
            const seconds = String(date.getUTCSeconds()).padStart(2, '0');

            return `${hours}:${minutes}:${seconds}`;
        },
        playerEvents() {
            this.player.on('ready', (event) => {
                const instance = event.detail.plyr;
                instance?.embed?.unMute();
                instance?.embed?.setVolume(100);
                this.$refs.videoDuration.innerHTML = this.formatTime(instance.duration);
                this.$refs.scrubber.max = instance.duration;
                this.$refs.scrubber.value = instance.currentTime;
                this.$refs.currentTime.innerHTML = this.formatTime(instance.currentTime);
                // if (this.noRestart) {
                //     this.player.forward(this.currentPlayTime)
                //     instance.currentTime = "15";
                //
                //     this.noRestart = false;
                // }
            });

            this.player.on('timeupdate', (event) => {
                const instance = event.detail.plyr;
                this.$refs.scrubber.value = instance.currentTime;
                this.$refs.currentTime.innerHTML = this.formatTime(instance.currentTime);
                this.currentPlayTime = instance.currentTime;
            });

            this.player.on('pause', () => {
                this.pause = this.playing;
                this.playing = null;
                this.$dispatch('gvp-now-playing', null);
            });
            this.player.on('playing', (event) => {
                const instance = event.detail.plyr;
                this.playing = instance?.source;
                this.currentPlayTime = event.detail.plyr?.currentTime
                this.$dispatch('gvp-now-playing', this.playing);
            });
            this.player.on('ended', () => {
                // this.changeSource('next');
            });
            this.player.on('error', () => {
                // this.changeSource('next');
            });

            this.player.on('stalled', () => {
                // this.changeSource('next');
            });
        },
        changeSource(direction: string) {
            this.player.togglePlay();
            if (direction == 'next') {
                this.currentlyPlayingIndex = this.currentlyPlayingIndex + 1;

                if (this.currentlyPlayingIndex == this.playlist.length) {
                    this.currentlyPlayingIndex = 0;
                }
            } else {
                this.currentlyPlayingIndex = this.currentlyPlayingIndex - 1;
                if (this.currentlyPlayingIndex < 0) {
                    this.currentlyPlayingIndex = this.playlist.length - 1;
                }
            }

            this.queueOrPauseContent(this.playlist[this.currentlyPlayingIndex].youtube_id);
        }
    }
}


