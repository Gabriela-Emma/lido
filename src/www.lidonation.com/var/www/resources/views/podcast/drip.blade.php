<div class="rounded-sm podcast-wrapper"
     x-data="{
        playing: false,
        queued: null,
        splide: null,
        streamId: @js($post->stream_id),
        init() {
            this.initSlides();
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
            if (this.playing && this.splide && this.splide.length > 1) {
                this.splide.go(1);
            }
            if(!event?.detail?.includes(this.streamId)) {
                this.queued = false;
            } else {}
        },
        initSlides() {
            const { shaders } = SplideShaderCarousel;
            const options = {
                type      : 'fade',
                height: 380,
                width: 380,
                rewind    : false,
                continuous: false,
                pagination: false,
                arrows: false,
                drag: false,
                mediaQuery: 'min',
                mask      : '/img/wave01.jpg',
                material: {
                    intensity: 0.5
                },
                breakpoints: {
                    1024: {
                        height: 420,
                        width: 420
                    },
                    1280: {
                        height: 480,
                        width: 480
                    },
                    1650: {
                        height: 540,
                        width: 540
                    }
                }
            };
            if ( SplideShaderCarousel.isAvailable() ) {
              this.splide = new SplideShaderCarousel( this.$refs.podcastSlides, shaders.maskShader, options );
              this.splide.mountAsync();
            } else {
              this.splide = new Splide( this.$refs.podcastSlides, options );
              this.splide.mount();
            }
        }
    }">
    <div class="flex shrink-0 snap-start flex-col gap-2 items-start justify-center podcast-inner">
        <div class="relative w-full">
            <div class="splide podcast-slides w-full"
                 x-ref="podcastSlides" id="lido-minute-{{$post->id}}"
                 aria-label="{{$post->title}} slid">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide relative">
                            <img src="{{$post->thumbnail_url}}" alt="">
                            @include('podcast.info-bar')
                        </div>

                        @if($post?->nfts?->filter(fn($nft) => $nft->promos->isNotEmpty())->isNotEmpty() && $post?->nfts->filter(fn($nft) => $nft->promos->isNotEmpty())?->random()?->promos?->isNotEmpty())
                            <div class="splide__slide relative">
                                <x-podcast.promo
                                    :promo="$post->nfts->filter(fn($nft) => $nft->promos->isNotEmpty())?->random()?->promos?->random()"
                                    :post="$post" />
                                @include('podcast.info-bar')
                            </div>
                        @else
                            <div class="splide__slide relative">
                                <img src="{{$post->thumbnail_url}}" alt="">
                                @include('podcast.info-bar')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
