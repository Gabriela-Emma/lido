<x-public-layout class="category" :metaTitle="'Cat: ' . $category->title">
    <header>
        <div class="container py-4">
            <div class="pb-4">
                <div class="flex flex-row gap-4 text-sm">
                    <div>
                        <span class="font-bold text-gray-300">
                            Today
                        </span>
                        <span>
                        {{now()->format('F d')}}
                        </span>
                    </div>
                    @if($adaQuote)
                    <div title="current price of ada according to Coin Market Cap">
                        <span class="font-bold text-gray-300">
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
            <hr class="border-gray-200" />
            <div>
                <h1 class="py-8 text-3xl font-extrabold md:text-5xl lg:text-6xl 2xl:text-8xl lg:py-12 2xl:py-8">
                    {{$category->title}} ({{$postsCount}})
                </h1>
            </div>
            <hr class="border-gray-300" />
        </div>
    </header>

    <section class="relative py-8 bg-scroll bg-center bg-cover bg-pool-bw-light bg-gray-50 bg-blend-hard-light"
            aria-labelledby="quick-links-title">
        <div class="container">
            <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 mt-8">
                @foreach($category->models as $post)
                    @if($loop->first)
                        @include("post.highlight")
                        <div class="col-span-2 xl:col-span-3 2xl:col-span-4 my-4"></div>
                    @else
                        <div class="p-8 border border-gray-300 -mt-px -ml-px">
                            <?php $showHero = true; ?>
                            @include("post.drip")
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
