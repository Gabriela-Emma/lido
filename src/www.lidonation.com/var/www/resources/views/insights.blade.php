<x-public-layout class="news" :metaTitle="$title">
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
                            Price
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
                <h1 class="text-3xl md:text-5xl lg:text-6xl 2xl:text-8xl font-extrabold py-8 lg:py-12 2xl:py-8">
                    {{$title}}
                </h1>
            </div>
            <hr class="border-gray-300"/>
        </div>
    </header>
    <section class="relative py-8 bg-pool-bw-light bg-cover bg-center bg-scroll bg-gray-50 bg-blend-hard-light"
             aria-labelledby="quick-links-title">
        <div class="container">
{{--            @foreach($insights->take(1) as $post)--}}
{{--                @include("post.feature")--}}
{{--            @endforeach--}}
            <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 mt-8">
                @foreach($insights as $post)
                    <div class="p-8 border border-gray-300 -mt-px -ml-px">
                        <?php $showHero = true; ?>
                        @include('post.drip')
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <?php $collection = 'insights'; ?>

    @include('pagination')

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
