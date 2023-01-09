<x-public-layout class="news" metaTitle="Cardano and Crypto News">
    <header>
        <div class="container py-4">
            <div class="pb-4">
                <div class="flex flex-row gap-4 text-sm">
                    <div>
                        <span class="text-gray-300 font-bold">
                            Today
                        </span>
                        <span>
                        {{now()->format('F d')}}
                        </span>
                    </div>
                    @if($adaQuote)
                        <div title="current price of ada according to Coin Market Cap">
                        <span class="text-gray-300 font-bold">
                            1 ₳ =
                        </span>
                            <span>
                            ${{ number_format($adaQuote?->price, 2, '.', '.') }}
                        </span>
                        </div>
                    @endif
                </div>
                <div>

                </div>
            </div>
            <hr class="border-gray-300"/>
            <div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl 2xl:text-8xl font-extrabold py-8 lg:py-12 2xl:py-8">Cardano
                    & Crypto News</h1>
            </div>
            <hr class="border-gray-300"/>
        </div>
    </header>
    <section class="relative py-8 bg-pool-bw-light bg-cover bg-center bg-scroll bg-gray-50 bg-blend-hard-light"
             aria-labelledby="quick-links-title">
        <div class="container">
            <div
                class="lg:grid gap-16 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 lg:gap-x-5 lg:gap-y-12 2xl:gap-x-8">
                @foreach($news as $post)
{{--                    @if($loop->first)--}}
{{--                        @include("post.feature")--}}
{{--                        <div class="col-span-2 xl:col-span-3 2xl:col-span-4">--}}
{{--                            <hr class="my-4 border-gray-300"/>--}}
{{--                        </div>--}}
{{--                    @elseif($loop->iteration === 2)--}}
{{--                        @include("post.highlight")--}}
{{--                        <div class="col-span-2 xl:col-span-3 2xl:col-span-4">--}}
{{--                            <hr class="my-4 border-gray-300"/>--}}
{{--                        </div>--}}
{{--                    @else--}}
                        <?php $showHero = true; ?>
                        @include("post.drip")
                        <div class="col-span-2 xl:col-span-3 2xl:col-span-4 lg:hidden">
                            <hr class="my-8 border-gray-300"/>
                        </div>
{{--                    @endif--}}
                @endforeach
            </div>
        </div>
    </section>

    <?php $collection = 'news'; ?>
   @include('pagination')

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
