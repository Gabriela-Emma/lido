<x-public-layout class="overflow-x-hidden bazaar" :metaTitle="$metaTitle">
    <header class="py-16 relative z-20">
        <div class="container">
            <h1 class="text-3xl font-medium leading-8 tracking-tight text-slate-800 sm:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl pr-0.5 pr8 xl:pr20  2xl:pr-322xl:max-w-7xl inline bg-white">
                <span class="font-extrabold text-green-500 inline">LIDO Bazaar.</span>
                <span class="inline">
                    Curated wares for Lido Nation supporters & the Cardano community.
                </span>
            </h1>
        </div>
    </header>

    <section class="py-16 white overflow-hidden">
        <div class="container">
            <div class="pt-16 pb-80 sm:pt-24 sm:pb-40 lg:pt-16 lg:pb-48">
                <div class="relative sm:static">
                    <div class="sm:max-w-lg xl:max-w-xl z-20 relative">
                        <h1 class="font text-4xl font-bold tracking-snug sm:leading-normal text-gray-900 sm:text-5xl lg:text-6xl inline bg-white px-0.5 lg:leading-tight">
                            A Day at the Lake NFT Series
                        </h1>
                        <div>
                            <p class="mt-4 text-xl text-gray-500 inline bg-white px-0.5 leading-none">
                                Share a poem, or your company, staking pool, NFT project, Project Catalyst proposal,
                                YouTube Channel or any content with the world!
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="mt-10">
                            <!-- Decorative image grid -->
                            <div aria-hidden="true"
                                 class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full">
                                <div
                                    class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-80 lg:-translate-x-8 xl:-translate-x-16">
                                    <div class="flex items-center space-x-6 lg:space-x-8">
                                        <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                            <div
                                                class="h-64 w-64 overflow-hidden rounded-lg sm:opacity-0 lg:opacity-100">
                                                <img src="{{$dayAtTheLakeItems->get(0)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                            <div class="h-64 w-64 overflow-hidden rounded-lg">
                                                <img src="{{$dayAtTheLakeItems->get(1)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                        </div>
                                        <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                            <div class="h-64 w-64 overflow-hidden rounded-lg">
                                                <img src="{{$dayAtTheLakeItems->get(2)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                            <div class="h-64 w-64 overflow-hidden rounded-lg">
                                                <img src="{{$dayAtTheLakeItems->get(3)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                            <div class="h-64 w-64 overflow-hidden rounded-lg">
                                                <img src="{{$dayAtTheLakeItems->get(4)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                        </div>
                                        <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                                            <div class="h-64 w-64 overflow-hidden rounded-lg">
                                                <img src="{{$dayAtTheLakeItems->get(5)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                            <div class="h-64 w-64 overflow-hidden rounded-lg">
                                                <img src="{{$dayAtTheLakeItems->get(6)?->preview_link}}" alt=""
                                                     class="h-full w-full object-cover object-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{localizeRoute('lido-minute-nft')}}"
                               class="inline-block rounded-sm border border-transparent bg-eggplant-500 py-3 px-8 text-center font-medium text-white hover:text-green-500 hover:bg-eggplant-700">
                                Learn More
                            </a>
{{--                            <a href="{{localizeRoute('mint-lido-minute')}}"--}}
{{--                               class="inline-block rounded-sm border border-transparent bg-green-500 py-3 px-8 text-center font-medium text-white hover:bg-green-700">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                          d="M16.712 4.33a9.027 9.027 0 011.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 00-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 010 9.424m-4.138-5.976a3.736 3.736 0 00-.88-1.388 3.737 3.737 0 00-1.388-.88m2.268 2.268a3.765 3.765 0 010 2.528m-2.268-4.796a3.765 3.765 0 00-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 01-1.388.88m2.268-2.268l4.138 3.448m0 0a9.027 9.027 0 01-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0l-3.448-4.138m3.448 4.138a9.014 9.014 0 01-9.424 0m5.976-4.138a3.765 3.765 0 01-2.528 0m0 0a3.736 3.736 0 01-1.388-.88 3.737 3.737 0 01-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 01-1.652-1.306 9.027 9.027 0 01-1.306-1.652m0 0l4.138-3.448M4.33 16.712a9.014 9.014 0 010-9.424m4.138 5.976a3.765 3.765 0 010-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 011.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 00-1.652 1.306A9.025 9.025 0 004.33 7.288"/>--}}
{{--                                </svg>--}}
{{--                                <span class="flex items-center gap-1">Mint</span>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-primary-10 py-16 sm:py-20">
        <div class="container">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-green-500 sm:text-4xl xl:text-5xl">
                <span class="block">
                    Shopping at the Bazaar
                </span>
                </h2>
                <h3 class="text-xl font-bold tracking-tight text-green-500 sm:text-2xl">
                <span class="block">
                    Is one way to directly support & contribute.
                </span>
                </h3>
                <p class="mt-8 text-lg font-semibold leading-6 text-slate-400">
                    Other ways to support LIDO
                </p>
                <div class="flex gap-2 justify-center mt-4">
                    <a type="button" href="{{localizeRoute('delegators')}}"
                       class="inline-flex items-center rounded-sm border border-transparent bg-yellow-500 px-4 py-2 text-base font-medium text-slate-800 shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        Delegate to LIDO
                    </a>
                    <a type="button" href="{{localizeRoute('lido-minute-nft')}}"
                       class="inline-flex items-center rounded-sm border border-transparent bg-green-500 px-4 py-2 text-base font-medium text-slate-800 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Sponsor a podcast episode
                    </a>
                </div>
            </div>

            <div class="mt-16 shadow-xs border-4 border-slate-800 rounded-sm">
                <x-lido.origin theme="green"/>
            </div>
        </div>
    </section>

    {{--    <section class="py-24 relative bg-white">--}}
    {{--        <div class="container relative">--}}
    {{--            <x-lido.origin theme="green" />--}}
    {{--        </div>--}}
    {{--    </section>--}}
</x-public-layout>
