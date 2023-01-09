import Plyr from "plyr";

export function globalVideoPlayer() {
    return {
        showVideo: false,
        paused: null,
        playing: null,
        queued: null,
        player: null,
        playlist: [],
        loadingVideo: false,
        init() {
            if (!this.player) {
                this.player = new Plyr(this.$refs.globalVideo, {
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
                this.playerEvents();
            }
        },
        queueOrPauseContent(event) {
            if (
                !this.playing?.includes(event.detail) &&
                !this.pause?.includes(event.detail)) {
                this.player.source = {
                    type: 'video',
                    sources: [
                        {
                            src: event.detail,
                            provider: 'youtube',
                        },
                    ],
                };
                this.loadingVideo = true;
                setTimeout(this.toggle(), 1100);

                const contentLoader = setInterval(() => {
                    if (!this.playing?.includes(event.detail) ) {
                        this.toggle();
                    } else {
                        clearInterval(contentLoader);
                        this.loadingVideo = false;
                    }
                }, 2200);
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
        padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        },
        formatTime(secs) {
            const minutes = Math.floor(secs / 60);
            const seconds = Math.floor(secs % 60);

            return `${this.padTo2Digits(minutes)}:${this.padTo2Digits(seconds)}`;
        },
        playerEvents() {
            this.player.on('ready', (event) => {
                const instance = event.detail.plyr;
                instance?.embed?.unMute();
                instance?.embed?.setVolume(100);
                this.$refs.scrubber.max = instance.duration;
                this.$refs.scrubber.value = instance.currentTime;
                this.$refs.currentTime.innerHTML = this.formatTime(instance.currentTime);
            });
            this.player.on('timeupdate', (event) => {
                const instance = event.detail.plyr;
                this.$refs.scrubber.value = instance.currentTime;
                this.$refs.currentTime.innerHTML = this.formatTime(instance.currentTime);
            });

            this.player.on('pause', () => {
                this.pause = this.playing;
                this.playing = null;
                this.$dispatch('gvp-now-playing', null);
            });
            this.player.on('playing', (event) => {
                this.playing = event.detail.plyr?.source;
                this.$dispatch('gvp-now-playing', this.playing);
            });
        }
    }
}
