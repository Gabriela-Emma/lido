@props([
    'podcast'
])
<div class="relative h-full rounded-sm"
    x-data="{
        playing: false,
        queued: null,
        streamId: @js($podcast->stream_id),
        init() {
            // this.initSlides();
        },
        togglePodcast() {
            if (this.queued) {
                this.$dispatch('load-podcast', this.streamId);
                this.queued = true;
            } else {
                this.$dispatch('toggle-podcast', this.streamId);
            }
        },
        handlePlaying(event) {
            this.playing = event?.detail?.includes(this.streamId);

            if(!event?.detail?.includes(this.streamId)) {
                this.queued = false;
            } else {}
        },
    }">
    <div class="flex flex-col items-start justify-center h-full gap-2 shrink-0 snap-start podcast-inner">
        <div class="relative w-full h-full">
            <div class="relative h-full">
                <img src="{{$podcast->thumbnail_url}}" alt="" class="w-full h-full">
                @include('components.podcast.info-bar')
            </div>
        </div>
    </div>
</div>
