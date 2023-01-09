<x-public-layout class="overflow-x-hidden lido-minute-podcast" :metaTitle="$metaTitle">
    <header class="py-16">
        <div class="container">
            <h1 class="text-2xl font-light leading-8 tracking-tight text-slate-800 sm:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl pr-8 xl:pr-20 2xl:max-w-7xl">
                <span class="font-extrabold text-yellow-500">Mint once.</span>
                <span>Advertise forever.</span>
            </h1>
        </div>
    </header>
    <section class="py-16 border-t">
        <div class="container">
            <h2 class="mb-4">
                Select the Lido Minute episode where you want your message to appear
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($available as $post)
                    <div class="relative">
                        <div
                            class="absolute group w-full h-full left-0 top-0 flex flex-col justify-center items-center z-20">
                            <div
                                class="absolute hidden group-hover:block left-0 top-0 w-full h-full z-index-0 bg-white bg-opacity-75 pointer-events-none"></div>
                            <div class="z-20 hidden group-hover:flex flex-col gap-3">
                                <a type="button"
                                   href="{{localizeRoute('mint-lido-minute-episode', null, ['podcast' => $post->id, 'pm' => 'dapp'])}}"
                                   class="inline-flex items-center rounded-sm border border-transparent bg-eggplant-500 px-2.5 py-1.5 text-xl xl:text-2xl font-medium text-white hover:bg-eggplant-800 focus:outline-none focus:ring-2 focus:ring-eggplant-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.712 4.33a9.027 9.027 0 011.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 00-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 010 9.424m-4.138-5.976a3.736 3.736 0 00-.88-1.388 3.737 3.737 0 00-1.388-.88m2.268 2.268a3.765 3.765 0 010 2.528m-2.268-4.796a3.765 3.765 0 00-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 01-1.388.88m2.268-2.268l4.138 3.448m0 0a9.027 9.027 0 01-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0l-3.448-4.138m3.448 4.138a9.014 9.014 0 01-9.424 0m5.976-4.138a3.765 3.765 0 01-2.528 0m0 0a3.736 3.736 0 01-1.388-.88 3.737 3.737 0 01-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 01-1.652-1.306 9.027 9.027 0 01-1.306-1.652m0 0l4.138-3.448M4.33 16.712a9.014 9.014 0 010-9.424m4.138 5.976a3.765 3.765 0 010-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 011.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 00-1.652 1.306A9.025 9.025 0 004.33 7.288"/>
                                    </svg>
                                    Mint
                                </a>
                                <div class="text-base text-center">
                                    <span>Available:</span>
                                    <span>{{$post->available_nfts_count}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="z-10">
                            <div class="rounded-sm podcast-wrapper">
                                <div
                                    class="flex shrink-0 snap-start flex-col gap-2 items-start justify-center podcast-inner">
                                    <div class="relative w-full">
                                        <div class=" relative">
                                            <img src="{{$post->thumbnail_url}}" alt="">
                                            <?php $disablePlayer = true; ?>
                                            @include('podcast.info-bar')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                {{ $available->onEachSide(5)->links() }}
            </div>
        </div>
    </section>


</x-public-layout>
