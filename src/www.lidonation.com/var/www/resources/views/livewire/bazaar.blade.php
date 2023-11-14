<div class="overflow-x-hidden bazaar">
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
                            <livewire:components.nft-image-grid-component lazy="on-load"/>

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
            <livewire:components.support-lido-component lazy="on-scroll"
                                                        theme="green"
                                                        title="Shopping at the Bazaar"
                                                        subtitle="Is one way to directly support & contribute."
                                                        :links="['delegate', 'podcast']"
                                                        cta="Other ways to support LIDO"
            />
        </div>
    </section>
</div>
