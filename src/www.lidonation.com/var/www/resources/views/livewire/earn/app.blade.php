<div>
    <section class="relative min-h-screen z-0 border-t border-slate-200">
        <div class="sticky top-0 z-20 bg-white border-b page-nav border-slate-800">
            <div class='container'>
                <nav class="flex flex-row justify-end ">
                    <ul class="flex flex-row items-center justify-end gap-2 text-sm">
                        <li class="flow-root menu-item">
                            <a href="#delegators" class="flex text-slate-800 menu-link">
                            <span class="px-1 py-3">
                                {{ $snippets->top}}
                            </span>
                            </a>
                        </li>
                        <li class="flow-root p-2 menu-item">
                            <x-delegators.connect-wallet/>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="h-full text-white bg-teal-800 rounded-sm">
            <div class="py-4 text-center border-b border-teal-900 xl:mb-8">
                <h2 class="p-4 mx-auto text-center font-display xl:text-4xl">
                    Catalyst Circle Voting (ccv4)
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">
                <div class="flex flex-col justify-center">
                    <div class="m-8 p-8 py-10 bg-teal-900 rounded-sm">
                        @include('livewire.earn.ccv-reward')
                    </div>
                </div>
                <div class="">
                    <div class="px-8 xl:px-8 2xl:px-16">
                        <div class="px-4 py-4 mb-8 border-4 border-teal-900 rounded-sm xl:px-8 2xl:px-16">
                            <div class="mb-2 text-xs text-center">
                                'everyEpoch title is brought to you by
                                <a href="{{$partnerPromo->uri}}" class="font-semibold" target="_blank">
                                    {{$partnerPromo->title}}
                                </a>
                            </div>
                            <div class="relative rounded-sm">
                                <x-podcast.promo :promo="$partnerPromo"/>
                            </div>
                        </div>
                        <p class="mx-auto mb-1 text-xs text-center">
                            Put your ad here:
                            <a title="Lido Advertisement NFTs" href="https://www.lidonation.com/lido-minute-nft">Lido Ad NFT</a>
                        </p>
                    </div>
                </div>
            </div>
            <svg aria-hidden="true" width="0" height="0">
                <defs>
                    <clipPath id=":R9m:-0" clipPathUnits="objectBoundingBox">
                        <path
                            d="M0,0 h0.729 v0.129 h0.121 l-0.016,0.032 C0.815,0.198,0.843,0.243,0.885,0.243 H1 v0.757 H0.271 v-0.086 l-0.121,0.057 v-0.214 c0,-0.032,-0.026,-0.057,-0.057,-0.057 H0 V0"></path>
                    </clipPath>
                    <clipPath id=":R9m:-1" clipPathUnits="objectBoundingBox">
                        <path
                            d="M1,1 H0.271 v-0.129 H0.15 l0.016,-0.032 C0.185,0.802,0.157,0.757,0.115,0.757 H0 V0 h0.729 v0.086 l0.121,-0.057 v0.214 c0,0.032,0.026,0.057,0.057,0.057 h0.093 v0.7"></path>
                    </clipPath>
                    <clipPath id=":R9m:-2" clipPathUnits="objectBoundingBox">
                        <path
                            d="M1,0 H0.271 v0.129 H0.15 l0.016,0.032 C0.185,0.198,0.157,0.243,0.115,0.243 H0 v0.757 h0.729 v-0.086 l0.121,0.057 v-0.214 c0,-0.032,0.026,-0.057,0.057,-0.057 h0.093 V0"></path>
                    </clipPath>
                </defs>
            </svg>
        </div>
    </section>
    <section class="fixed z-40 w-full bg-transparent pointer-events-none bottom-4">
        <x-notice/>
    </section>
</div>

