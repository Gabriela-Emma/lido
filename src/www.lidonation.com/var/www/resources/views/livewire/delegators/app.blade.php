<div class="min-h-screen">
    <div class="sticky top-0 z-20 border-b bg-white page-nav border-slate-800">
        <div class='container'>
            <nav class="justify-end flexflex-row">
                <ul class="flex flex-row items-center justify-end gap-2 text-sm">
                    <li class="flow-root menu-item">
                        <a href="#delegators" class="flex text-slate-800 menu-link">
                        <span class="px-1 py-3">
                            {{ $snippets->top}}
                        </span>
                        </a>
                    </li>
                    <li class="flow-root menu-item p-2">
                        <x-delegators.connect-wallet/>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <section class="py-12 relative bg-white h-[45rem] xl:h-[54rem] border-b border-slate-800" id="hosky-rugpool"
             x-data="hoskyVideo">
        <div class="relative flex justify-center items-center overflow-hidden h-full">
            <div class="absolute left-0 top-0 w-full overflow-visible z-10"
                 x-transition :class="{
                    'h-[12rem] xl:h-[0rem]' : !!playing,
                    'h-[28rem] xl:h-[38rem]': !playing
                 }"
                 x-show="playing" x-transition.duration.500ms x-cloak>
                <div class="flex flex-col gap-3 justify-center items-center justify-center h-full mx-auto">
                    <div class="bg-white w-11/12 md:w-9/12 h-3/5">
                        <div class="plyr__video-embed rounded-sm"
                             x-ref="lidoHoskyPoolVideo"
                             data-plyr-provider="youtube"
                             data-plyr-embed-id="PUsejt8_EPA">
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute left-0 top-0 w-full h-full z-5" x-show="!playing" x-transition>
                <div class="flex flex-col gap-3 justify-center items-center justify-center h-full">
                    <img alt="hosky logo" class="w-20 h-20" src="{{asset('img/hosky-logo.png')}}"/>
                    <h2 class="text-lg lg:text-xl xl:text-2xl font-semibold text-slate-900 flex items-center gap-2">
                        <span class="mr2">LIDO is a </span><span>$HOSKY Token Rug Pool</span>
                    </h2>
                    <div class="max-w-sm mx-auto font-normal text-lg">
                        <p class="">
                            As a LIDO delegator you can get FREE $HOSKY tokens every epoch! These famously low-value
                            doggie meme coins might not be worth much - but who doesn't want to be a billionaire anyway?
                        </p>
                        <p>
                            To get your allocation of $HOSKY, simply send ₳2 to adahandle: <span class="font-bold">$rugpool</span>
                        </p>
                        <p>
                            About 1.7 ada will be returned to your wallet, along with your allocation of $HOSKY for that
                            epoch. This does not affect your normal ada rewards, and you can go back every epoch (5
                            days) for more!
                        </p>
                    </div>
                    <div class="text-yellow-500 hover:cursor-pointer hover:text-green-500" @click="play">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-16 h-16">
                            <path fill-rule="evenodd"
                                  d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="absolute left-0 top-0 w-full h-full z-0">
                <div class="flex justify-center items-start md:items-center w-full h-full">
                    <svg id="visual" viewBox="0 0 800 800"
                         width="880" height="800" x-transition.duration.500ms
                         :class="{
                                '-translate-x-80 -translate-y-40 md:translate-y-0 md:-translate-x-90 transition-transform': !!playing
                             }"
                         xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
                        <g transform="translate(335.6613026846675 403.21026300226055)">
                            <path id="hosky-blob1"
                                  d="M202.2 -338C264.7 -314.1 319.8 -265.3 368.2 -204.8C416.7 -144.3 458.3 -72.2 456.5 -1.1C454.6 70 409.2 140 359.2 197.7C309.2 255.5 254.6 300.9 194 325.9C133.3 350.9 66.7 355.5 2.8 350.7C-61.2 345.9 -122.3 331.9 -158.4 292.7C-194.5 253.6 -205.5 189.3 -235.4 136.3C-265.3 83.3 -314.2 41.7 -325.3 -6.4C-336.4 -54.5 -309.8 -109 -281.2 -164.3C-252.6 -219.6 -222.1 -275.6 -174.9 -308.4C-127.7 -341.1 -63.8 -350.6 3 -355.8C69.8 -361 139.7 -361.9 202.2 -338"
                                  fill="#54bbeb"></path>
                            <path id="hosky-blob2" class="invisible"
                                  d="M143.7 -239.7C200.7 -215.9 271.4 -206.7 333.1 -169.2C394.7 -131.7 447.4 -65.8 432.3 -8.7C417.3 48.5 334.7 97 273.3 135C211.8 172.9 171.7 200.3 129.7 235.6C87.7 270.8 43.8 313.9 -5.5 323.4C-54.8 333 -109.7 308.9 -145.8 270.3C-181.8 231.6 -199.2 178.3 -219.3 130.8C-239.3 83.3 -262.2 41.7 -267.7 -3.2C-273.1 -48 -261.3 -96 -246.2 -152.1C-231.1 -208.3 -212.8 -272.6 -171.2 -305.3C-129.7 -337.9 -64.8 -339 -10.8 -320.3C43.3 -301.7 86.7 -263.4 143.7 -239.7"
                                  fill="#3aa0c4"></path>
                        </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{--        <section class="py-12 relative bg-white" id="delegators">--}}
    {{--            <div class="container relative">--}}
    {{--                <div class="gap-4">--}}
    {{--                    <div class="col-span-2 text-slate-800">--}}
    {{--                        <div class="grid grid-cols-5 relative">--}}
    {{--                            <div class="col-span-4">--}}
    {{--                                <h2 class="text-4xl sm:pr-8 md:pr-0 md:text-5xl lg:text-6xl xl:text-7xl 2xl:text-8xl mb-4 xl:pr-24 capitalize">--}}
    {{--                                    Cardano Foundation recognizes <b--}}
    {{--                                        class="font-bold text-teal-700 uppercase">LIDO</b><br/>--}}
    {{--                                    staking pool!--}}
    {{--                                </h2>--}}
    {{--                            </div>--}}
    {{--                            <div class="absolute top-0 right-0 text-right">--}}
    {{--                                <p class="font-title text-xl sm:text-2xl lg:text-4xl 2xl:text-6xl relative lg:top-3 tracking-wider">--}}
    {{--                                    +14,557,448 ₳--}}
    {{--                                </p>--}}
    {{--                                <div--}}
    {{--                                    class="max-w-[10rem] sm:max-w-[12rem] md:max-w-[13rem] lg:max-w-[18rem] xl:max-w-[24rem] 2xl:max-w-[28rem] inline-flex justify-end items-start ml-auto">--}}
    {{--                                    <img--}}
    {{--                                        class="w-full h-auto embed-responsive-4by3 ml-auto relative -top-8 xl:-top-12 2xl:-right-6"--}}
    {{--                                        src="https://pool.pm/whale_l.svg" alt="whale shark">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <p class="text-xl md:text-2xl xl:text-3xl">--}}
    {{--                            That means that we will start to mint blocks every epoch - because our pool “saturation" is--}}
    {{--                            now at a level that we will frequently be “picked” by the Ouroboros protocol.--}}
    {{--                        </p>--}}
    {{--                        <p class="text-xl md:text-2xl xl:text-3xl">--}}
    {{--                            That means that you, our current and future delegators, will receive rewards in your Cardano--}}
    {{--                            wallet every epoch.--}}
    {{--                        </p>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </section>--}}

    <section id="delegator-portal" class="relative bg-white pt-12">
        <div class="container relative">
            <div class="gap-6 md:grid md:grid-cols-2 2xl:grid-cols-5">
                <div
                    class="rounded-sm bg-gradient-to-br from-teal-800 via-teal-600 to-teal-900 w-full p-8 2xl:col-span-2 relative">
                    <div
                        :class="{'hidden': !working, 'absolute': working}"
                        class="z-10 flex items-center justify-center hidden w-full h-0 p-0 overflow-visible top-1/2">
                        <div
                            class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                            <svg
                                class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"
                                viewBox="0 0 24 24"></svg>
                        </div>
                    </div>
                    <template x-if="delegationTransactionId">
                        <x-delegators.delegation-success />
                    </template>
                    <template x-if="isDelegatedToLido">
                        @include('components.delegators.portal')
                    </template>
                    <template x-if="!isDelegatedToLido && showRewards">
                        <main class="text-white relative">
                            @include('components.delegators.portal-rewards')
                        </main>
                    </template>
                    <template x-if="!isDelegatedToLido && !showRewards">
                        <div class="flex flex-col justify-start items-start gap-4 relative">
                            <x-delegators.delegate-cta/>

                            <x-delegators.delegate/>

                            @if($availableRewards?->isNotEmpty())
                                <div class="mt-8 mx-auto bg-teal-700/80 z-5">
                                    <x-delegators.portal-has-rewards-cta/>
                                </div>
                            @endif
                        </div>
                    </template>
                    <div class="inline-flex mt-auto absolute right-4 -bottom-12 z-0 pointer-events-none">
                        <div class="w-[20rem] text-white opacity-25">
                            @include('svg.lido-logo')
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-sm bg-gradient-to-br from-primary-10 to-primary-20 via-slate-50  w-full p-8 2xl:col-span-3">
                    <div class="relative">
                        <div
                            :class="{'hidden': !loadingBlocks, 'absolute': loadingBlocks}"
                            class="z-10 flex items-center justify-center hidden w-full h-full p-0 overflow-visible">
                            <div
                                class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                                <svg
                                    class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"
                                    viewBox="0 0 24 24"></svg>
                            </div>
                        </div>
                        <div class="sm:flex sm:items-start">
                            <div class="sm:flex-auto text-lg">
                                <h1 class="text-2xl xl:text-4xl 2xl:text-6xl font-semibold text-slate-900 flex items-end flex-row gap-2">
                                    <span>Blocks</span>
                                </h1>
                                <div class="flex flex-row gap-y-3 gap-x-6 flex-wrap">
                                    <div class="flex gap-2 items-center">
                                        <div class="text-slate-500 text-sm xl:text-base">Total Blocks</div>
                                        <div class="font-bold text-base xl:text-xl"
                                             x-text="poolDetails?.blocks_minted || '-'"></div>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <div class="text-slate-500 text-sm xl:text-base">Blocks in Epoch</div>
                                        <div class="font-bold text-base xl:text-xl"
                                             x-text="poolDetails?.blocks_epoch || '-'"></div>
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <div class="text-slate-500 text-sm xl:text-base">Live Stake</div>
                                        <div class="font-bold text-base xl:text-xl"
                                             x-text="poolLiveStake ? poolLiveStake + ' ₳' : '-'"></div>
                                    </div>
                                </div>
                                <p class="mt-8 text-slate-700 text-xl xl:text-2xl">
                                    Recent blocks & upcoming assignments
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div
                                    class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8 max-h-[28rem] overflow-y-auto min-h-[32rem]">
                                    <x-delegators.blocks/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($everyEpoch && ($everyEpochQuiz || $everyEpoch->giveaway))
        <section class="py-12 mt-12 border-t border-slate-200 every-epoch" id="everyEpoch" x-data="everyEpoch">
            <div class="container">
                <div class="bg-teal-800 rounded-sm text-white">
                    <div class="xl:mb-8 border-b border-teal-900 py-4 text-center">
                        <h2 class="font-display text-center mx-auto xl:text-4xl p-4">
                            {{$everyEpoch->title}}
                        </h2>
                        <div
                            class="flex flex-row flex-wrap justify-center items-center xl:justify-start gap-8 xl:gap-4 px-8">

                            <div class="text-green-500">
                                @if($this->rewardPot?->isNotEmpty())
                                    <div
                                        class="-rotate-45relative -left-24-bottom-1 font-semibold mb-2 w-full xl:text-left text-xs">
                                        Available in Prizes for completing successfully.
                                    </div>
                                @endif

                                <livewire:rewards.lido-rewards-pot-component :every-epoch="$everyEpoch" />
                            </div>


                            <div class="max-w-xl mx-auto font-normal text-lg text-center px-4">
                                <x-markdown>{{$everyEpoch->content}}</x-markdown>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <div class="flex flex-col justify-center">
                            <div class="p-8 bg-teal-900 rounded-sm py-10">
                                @include('livewire.delegators.quiz')
                            </div>
                        </div>
                        <div class="">
                            <div class="px-8 xl:px-8 2xl:px-16">
                                <div class="border-4 mb-8 rounded-sm border-teal-900 py-4 px-4 xl:px-8 2xl:px-16">
                                    <div class="text-xs text-center mb-2">
                                        {{$everyEpoch->title}} is brought to you by
                                        <a href="{{$partnerPromo->uri}}" class="font-semibold" target="_blank">
                                            {{$partnerPromo->title}}
                                        </a>
                                    </div>
                                    <div class="rounded-sm relative">
                                        <x-podcast.promo :promo="$partnerPromo"/>
                                    </div>
                                </div>
                                <p class="text-xs text-center mx-auto mb-1">
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
            </div>
        </section>
    @endif

    <section class="pb-16 pt-6 relative bg-white">
        <div class="container relative">
            <x-lido.origin/>
        </div>
    </section>

    {{--        <section class="mb-8">--}}
    {{--            <div class="relative bg-white overflow-hidden">--}}
    {{--                <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2">--}}
    {{--                    <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"--}}
    {{--                         src="{{asset('img/lido-pool-2.jpg')}}" alt="">--}}
    {{--                </div>--}}

    {{--                <div class="max-w-7xl mx-auto">--}}
    {{--                    <div--}}
    {{--                        class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 ml-auto">--}}
    {{--                        <svg--}}
    {{--                            class="hidden lg:block absolute left-0 inset-y-0 h-full w-48 text-white transform translate-x1/2 rotate-[175deg] translate-x-[-5.75rem]"--}}
    {{--                            fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">--}}
    {{--                            <polygon points="50,0 100,0 50,100 0,100"/>--}}
    {{--                        </svg>--}}

    {{--                        <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">--}}
    {{--                            <div class="sm:text-center lg:text-left pl-16">--}}
    {{--                                <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">--}}
    {{--                                <span class="block xl:inline">--}}
    {{--                                    Our Why--}}
    {{--                                </span>--}}
    {{--                                    --}}{{--                                <span class="block text-teal-600 xl:inline">online business</span>--}}
    {{--                                </h1>--}}
    {{--                                <div--}}
    {{--                                    class="text-base text-slate-600 mt-3 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">--}}
    {{--                                    <p>--}}
    {{--                                        Blockchains are about decentralization, and decentralization means involving a--}}
    {{--                                        lot--}}
    {{--                                        of people, from lots of places of the world.--}}
    {{--                                        The more decentralized a network is, the stronger it is. Therefore, a growing--}}
    {{--                                        and--}}
    {{--                                        resilient network needs to appeal not just to the people who are already in it:--}}
    {{--                                    </p>--}}
    {{--                                    <p class="text-slate-800 font-bold text-xl">--}}
    {{--                                        It needs to be attractive to newcomers, to curious explorers from other--}}
    {{--                                        blockchains,--}}
    {{--                                        and to people who don’t just speak English!--}}
    {{--                                    </p>--}}
    {{--                                    <p>We write about introductory topics, complex topics, and news from the--}}
    {{--                                        block-o-sphere.</p>--}}
    {{--                                    <p>--}}
    {{--                                        No matter the topic, we write in a way that a newcomer could start to understand--}}
    {{--                                        ---}}
    {{--                                        and an O.G. might still learn something!--}}
    {{--                                    </p>--}}
    {{--                                    <p>--}}
    {{--                                        We started to translate our articles into Swahili and Spanish - two high-impact--}}
    {{--                                        languages to reach new continents with accessible blockchain education.--}}
    {{--                                    </p>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </section>--}}

    <section class="mb-16 relative">
        <div class="relative bg-white overflow-hidden">
            <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                     src="{{asset('img/lido-pond-1.jpg')}}" alt="">
            </div>

            <div class="container h-full">
                <div
                    class="relative z-10 pb8 bg-white lg:max-w-2xl lg:w-full h-full ml-auto">
                    <svg
                        class="hidden lg:block absolute left-0 inset-y-0 h-full w-60 text-white transform translate-x1/2 rotate-[175deg] translate-x-[-6rem] 2xl:translate-x-[-9rem] -translate-y-1"
                        fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                        <polygon points="50,0 100,0 50,100 0,100"/>
                    </svg>

                    <div class="mx-auto max-w-7xl">
                        <div class="sm:text-center lg:text-left pl-28 2xl:pl-16 pt-16">
                            <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">
                                    Our Why
                                </span>
                            </h1>
                            <div
                                class="text-base text-slate-600 mt-3 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                <p>
                                    Blockchains are about decentralization, and decentralization means involving a
                                    lot
                                    of people, from lots of places of the world.
                                    The more decentralized a network is, the stronger it is. Therefore, a growing
                                    and
                                    resilient network needs to appeal not just to the people who are already in it:
                                </p>
                                <p class="text-slate-800 font-bold text-xl">
                                    It needs to be attractive to newcomers, to curious explorers from other
                                    blockchains,
                                    and to people who don’t just speak English!
                                </p>
                                <p>We write about introductory topics, complex topics, and news from the
                                    block-o-sphere.</p>
                                <p>
                                    No matter the topic, we write in a way that a newcomer could start to understand
                                    -
                                    and an O.G. might still learn something!
                                </p>
                                <p>
                                    We started to translate our articles into Swahili and Spanish - two high-impact
                                    languages to reach new continents with accessible blockchain education.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--        <section class="mb-16">--}}
    {{--            <div class="relative bg-white overflow-hidden">--}}
    {{--                <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2">--}}
    {{--                    <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"--}}
    {{--                         src="{{asset('img/lido-pond-3.jpg')}}" alt="">--}}
    {{--                </div>--}}

    {{--                <div class="max-w-7xl mx-auto">--}}
    {{--                    <div--}}
    {{--                        class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 ml-auto">--}}
    {{--                        <svg--}}
    {{--                            class="hidden lg:block absolute left-0 inset-y-0 h-full w-48 text-white transform translate-x1/2 rotate-[175deg] translate-x-[-5.75rem]"--}}
    {{--                            fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">--}}
    {{--                            <polygon points="50,0 100,0 50,100 0,100"/>--}}
    {{--                        </svg>--}}

    {{--                        <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">--}}
    {{--                            <div class="sm:text-center lg:text-left pl-16">--}}
    {{--                                <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">--}}
    {{--                                <span class="block xl:inline">--}}
    {{--                                    Our Why--}}
    {{--                                </span>--}}
    {{--                                    --}}{{--                                <span class="block text-teal-600 xl:inline">online business</span>--}}
    {{--                                </h1>--}}
    {{--                                <div--}}
    {{--                                    class="text-base text-slate-600 mt-3 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">--}}
    {{--                                    <p>--}}
    {{--                                        Blockchains are about decentralization, and decentralization means involving a--}}
    {{--                                        lot--}}
    {{--                                        of people, from lots of places of the world.--}}
    {{--                                        The more decentralized a network is, the stronger it is. Therefore, a growing--}}
    {{--                                        and--}}
    {{--                                        resilient network needs to appeal not just to the people who are already in it:--}}
    {{--                                    </p>--}}
    {{--                                    <p class="text-slate-800 font-bold text-xl">--}}
    {{--                                        It needs to be attractive to newcomers, to curious explorers from other--}}
    {{--                                        blockchains,--}}
    {{--                                        and to people who don’t just speak English!--}}
    {{--                                    </p>--}}
    {{--                                    <p>We write about introductory topics, complex topics, and news from the--}}
    {{--                                        block-o-sphere.</p>--}}
    {{--                                    <p>--}}
    {{--                                        No matter the topic, we write in a way that a newcomer could start to understand--}}
    {{--                                        ---}}
    {{--                                        and an O.G. might still learn something!--}}
    {{--                                    </p>--}}
    {{--                                    <p>--}}
    {{--                                        We started to translate our articles into Swahili and Spanish - two high-impact--}}
    {{--                                        languages to reach new continents with accessible blockchain education.--}}
    {{--                                    </p>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}


    {{--            <div class="grid grid-cols-2">--}}
    {{--                <div></div>--}}
    {{--                <div></div>--}}
    {{--            </div>--}}
    {{--        </section>--}}

    <section class="bg-white mb-16">
        <div class="container">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl 2xl:text-5xl">
                        Ready to jump in the Pool?
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg text-slate-600">
                        Whether you showed up today because you saw that we got the Foundation delegation, or
                        because you like the articles,
                        or because you are using the Project Catalyst tool, or because you just can’t wait to get
                        some Phuffy - we are glad you are here.
                    </p>
                    <p>
                        You can stake to Lido Nation by using our pool ticker LIDO or Pool ID
                        <span class="break-all select-all font-bold">b5a1a820cc3783a4e637bce79d1cc2774b241c08251e45c5d1f8f3f6</span>
                        in any Cardano wallet that supports staking.
                    </p>
                    <p>
                        After you delegate, be sure to create a login here at the website and register your wallet!
                        This step is optional - you can choose not to register your wallet.
                    </p>
                    <p>
                        Your stake will still support our pool and help secure the Cardano network, and you will
                        still receive all your staking rewards, automatically.
                        Registering is the only way to get your free Phuffy coins, and get access to other pool
                        member benefits.
                    </p>
                    <p>
                        If you need help, drop us a line: <a
                            href="{{localizeRoute('community')}}"> {{$snippets->connect}}</a>.
                    </p>
                    <p class="font-semibold">Because the future is for everyone!</p>
                </div>
                <div class="mt-8 grid md:grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-0 lg:grid-cols-2">
                    <div class="col-span-1 flex gap-3 justify-center items-center">
                        <h2 class="text-2xl 2xl:text-3xl"><span class="font-bold">Delegate with 1-click!</span></h2>
                    </div>
                    <div class="col-span-1 flex gap-3 justify-center items-center py-8 px-8 bg-slate-50">
                        <img alt="nami wallet logo" class="max-h-8 2xl:max-h-12"
                             src="data:image/png;base64,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"/>
                        <span class="text-slate-800 font-semibold hover:cursor-pointer hover:text-teal-700"
                              @click.stop="delegate('nami')"
                              x-show="walletService?.supports('nami')">
                            Nami
                        </span>
                        <span class="text-slate-300 text-sm 2xl:text-base"
                              x-show="!walletService?.supports('nami')">
                            Not Installed
                        </span>
                        <a href="//namiwallet.io"
                           target="_blank"
                           class="text-slate-400 text-xs flex flex-row gap-1 items-center"
                           x-show="!walletService?.supports('nami')">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                 fill="currentColor">a
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-span-1 flex gap-3 justify-center items-center py-8 px-8 bg-slate-50">
                        <img alt="flint wallet logo" class="max-h-8 2xl:max-h-12"
                             src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gKgSUNDX1BST0ZJTEUAAQEAAAKQbGNtcwQwAABtbnRyUkdCIFhZWiAAAAAAAAAAAAAAAABhY3NwQVBQTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9tYAAQAAAADTLWxjbXMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtkZXNjAAABCAAAADhjcHJ0AAABQAAAAE53dHB0AAABkAAAABRjaGFkAAABpAAAACxyWFlaAAAB0AAAABRiWFlaAAAB5AAAABRnWFlaAAAB+AAAABRyVFJDAAACDAAAACBnVFJDAAACLAAAACBiVFJDAAACTAAAACBjaHJtAAACbAAAACRtbHVjAAAAAAAAAAEAAAAMZW5VUwAAABwAAAAcAHMAUgBHAEIAIABiAHUAaQBsAHQALQBpAG4AAG1sdWMAAAAAAAAAAQAAAAxlblVTAAAAMgAAABwATgBvACAAYwBvAHAAeQByAGkAZwBoAHQALAAgAHUAcwBlACAAZgByAGUAZQBsAHkAAAAAWFlaIAAAAAAAAPbWAAEAAAAA0y1zZjMyAAAAAAABDEoAAAXj///zKgAAB5sAAP2H///7ov///aMAAAPYAADAlFhZWiAAAAAAAABvlAAAOO4AAAOQWFlaIAAAAAAAACSdAAAPgwAAtr5YWVogAAAAAAAAYqUAALeQAAAY3nBhcmEAAAAAAAMAAAACZmYAAPKnAAANWQAAE9AAAApbcGFyYQAAAAAAAwAAAAJmZgAA8qcAAA1ZAAAT0AAACltwYXJhAAAAAAADAAAAAmZmAADypwAADVkAABPQAAAKW2Nocm0AAAAAAAMAAAAAo9cAAFR7AABMzQAAmZoAACZmAAAPXP/bAEMABQMEBAQDBQQEBAUFBQYHDAgHBwcHDwsLCQwRDxISEQ8RERMWHBcTFBoVEREYIRgaHR0fHx8TFyIkIh4kHB4fHv/bAEMBBQUFBwYHDggIDh4UERQeHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHv/CABEIAZABkAMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAAAgYBAwQFB//EABoBAQACAwEAAAAAAAAAAAAAAAABAgMFBgT/2gAMAwEAAhADEAAAAfsoAAAAAABGEmiFZ6IaUTsjFWcsEhBnCUpayN8uZaOty7JjcjK0BIAAAAAAAAAAARhKGqFLTgVsEAAAAAAAAE4JdE+TZeu9jNqhIAAAAAAAAxoqnqwx3CJAAAAAAPO9GlwvQAAADO7QmOto3ZKZFgAAAAADDnrKJjuEAAAAAAHiKhqdxP6L84+j0ySG50YAAAACcEurPN0ZKZFoAAAAYzz1nETHcIAAAAAAPEVDU7hg0XQy+jfOfou40ewbvRAAAAAAJwS6s6N+TGFgAAjCGnOMVwiQAAAAAHiyp2q2+MGi6IIZ+h/O/oW20vSN7oAAAAAAAG7TmY6mM5aBIBz7efHYKWAAAAAAeTmmava4iaHowiQM/QPn192um7hvufAOeteb1W1T/dpb0x7PGAAABPo5OjJWYvUQhpiYsgQAAAAAeWpes2qBoOjCJAAz9Fpl43nPht9M5MUjX7BznPdOzhW119alXXpuTD2+IAABOCY60ZZaNO7lrOBjuAAAAA8zroev2OuBzvThEgAO6N42GszuOi5px4pHg2DQc90wVsB0fQ/nX0Xe8+G20wAAAG3dzdOSkOfdprIVsAAAAOStqz4pyfYhizAAY7o3nYa3HQdFzLz8UnXbLOo5/pAiwAG76L86+i73nw22mAAAAdPNvvWGuUayESAAAArljpvh9/jDmuqAAdOLx7tfPoOk5d50aVrdnnWaDowiwAAG76L86+i73nw22mAAAAbNc5iOCJAAAAAUu6UrWbPyRz/TAYlj1MmK0d51vHPJ9ak+T1+ZHdnnOn0NxOlKNbBEgAbvovzr6LvefDbaYAAABnGZYEAAAAAFKutK1m08kc/0oDs416fSZU60dLynS1vT5tjWNjGbV1VK5Q8vr+btmvl+sCLAbvovzr6LvefDbaYAAAAAzgAAAAAUq60rWbTyRz/SgAAZYTGWPXyYvTsMZdRyTGa7E1vUcp2ARYDd9F+f/QN7zwbbTgAAAM4zLMdmtARIAAAClXWlazaeSOf6UAAAevkxZuKXS8qPBy48VTDmepDz+oAD2LnW7J0nLB79eAAAAnDZMS09HPMBWwAAAClXWlazaeSOf6UAAepkxZuafS8sPBy4lTY5nqQ8/qAAZxYM2Cw9R1nHBMAAAAN+jpvWXL1aJjWMdwAAAFKutL1uz8gc90wA9TJizc0+l5YeDlxYqmHM9SHn9QAA6LV23rR19Jywe3wgAAAAZ6tO7JRCa0ciUcWQIAAAKhb+Hy+uhNmvl+tHqXx5uafS8sHq8nnUa01XnelDXbQAAdVqYvDq6LmQ9+vAAAAAE5jdIy0CUOfr58doClgAAAOXxLK8/or3vyWqGbCBXKvaqrzXUh4dgAOq1F4dPR8wHu8AAAAAADo1dGSoXqAjJDkbtOK4RIAAAAAAFeqtqqvN9QHg2I67UXh0dHzAe7wAAAAAAM43TE5GWgSAAc/Ris8qUcdwgAAAAABXqraqrzfUDu8fuXWW7o+XD2+EAAAAAASlLfjOTGFgAAAEefqjWeZKOO4QAAAAAr1Vtnh890mLu27XUB7PEAAAAAAJSdDOSgWgAAAAADGjoVnkbtOOwRIAAAGtsVkLQAAAAAAZ2zEd2WSgWAAAAAAAAIyQ54dcKW50o1sEAAAAAAAABOUJ7Z3rGRaoSAAAAAAAAAAAQmhoh1KzyOiNZ0tkYmLOIkAZMJSmNbdOY5571ojItASAAAAAA//EACoQAAIBAgUEAwEAAgMAAAAAAAECAwQwAAURIEAQEjEzEyE0MhRQIiRB/9oACAEBAAEFAuFqMd+O7Gp36nHccd+NR/oiRgtwNcd2AdeaWwSeKGOA3JJ0wTyQ2AdeMW5obiFteDLWRpNdDacE4J14OYVnxYUkyL/N0HTAvHBOvBzCs+IEklP7X+bwOmBdJ14OYVgiB+zhf6T+L6nS4x14OYVnxAnU9F8x+vgKbTng5hWCIEknqPMB1h4KGwToOBmFV8KkknbS/n4Q+97HU36+rEAYlm2/+0n3TcJTuc8CvqhArsWbfQfk2TTJCsuZSEx5lMDSVkc9xTqNjeb1dViBXYu29f6hXti61M6wR1EzzP0BIOXVPzR2l89W8Xq6rECuxZrGX05mm61U6QJPM80mzKWC1VtfHR71fUiBHYu1ijp2nkijWNOlVUJAk8rTPtpjpUW4+BUSrDHPK00tikp2nkhiWJOlXUJAk0rTPug99secN4u5rP8AJLYpadp3giWFOlZUrAksjSPvg99xfEl2sk+KnsUsDTyQRJCnStqVgSR2kexB77iYfzczp/8AhvpoWmkp4VhTpW1SwLLI0j2YPfcTy3m5nH691PC0z00CQR9K6qWBJHaRrUHvuL/V3Nv2bQCWooBBF0r6sQKzFmtwe+4PN3Nv2bcrUNV9a+KX/K+KXHxS4+KXHxS4ZWWxB7+Vm37NtFL8VQDqN8kaSCvozDvg9/Kzb9m6hrTDiOeKQd6Y70x3pjvTAIPVwGWUdsm2D38rNv2XMmD9nQ/QmOsu2D38rNv2W6CkMxUBR0zOq0G6kXvqLg8nzczb9lqgpDMVAUdMxrOwH7O7KB/27i/0/m5m37LOX0nzMoCjpmNZ2A/djJU+rieZLubfssUNIZ2RQi9MwrOyyoLNTR/FDcTDeLmbfs30NI07IoRemY1nZg/ZsZTT9zXV8Xc2/ZuoaQzsihF6ZjWdgP3Zo4DPLGoRLg89H8282/XtoKQzsiqi9MwrOwWaeF5npYFgjup1YfVvOFIqNlDSmdkUIvTMJ/hgJ1NinheaSmgSBLy+OrebVbB88MkbRt0oaRpmRQq9c79Vimged6eFII7yj72OPq3UQRzLJleIMtVSoCjZnf8AG+lgeeSnhSFL6jQbWGh4Wd+vdTQNPJTwrCl9fO5hqOFnfq200DzvTwpCnAA0G9xws79Wylgad4Ilhj4CC0w04Od+rrSUzVDwRJDHwFGts4I04Gd+rpR0zTvDGsScADW6Rrg/V/O/VijpmqHijWNOABrgXiNcEaXs6BMNHTNUPFGsScADXA4BGuGGl10V1jRUXgKuvEZeaF4xGuCvJC64A05JXBBHFCnAUc0gYK8ELgAD/Rdox2Y7TjQ79DjtOOzHaOH/AP/EACoRAAEDAgUDBAMBAQAAAAAAAAECAwQAEQUSIDAxECEyEyIzYSM0UUFC/9oACAEDAQE/Adi1Wq2i1Wq2/bctt22VNqQAVDnVarbAGzAgZ/yOcVjA8dgjUNmBAz/kXx0xn/nZO7h8D1PyL4oC3TGPFO6NiBA9T3r4oC3YdcYHsT1YiOv+Ip6A80LkdtR2oED1PevigLdhoxd0FQQP86QoJfOZXFIQECwq16nshp6w41jXh8P1lZlcCgLdhonTgyMqeaJJNzUKCXzmVxSUhAsOuMeadRoakJK1BIphoMoCRonTgwMqeaUoqNzUGAXvcrikpCRYaMY806jrw1GZ8fWidNDAsOaUoqNzUGAXfevikpCRYacY806jrwn5ury/TQVfylrK1ZjUBlDrnvoLQO169RH9oG/GjGPNO7hPzdXEBaSk1IhuMq47VlVWVXSLLWwrtxQNxfrjHmndwn5tNhTziGk5lVId9VwqqOyp5eVNJFhbrjB96d3Cfm0vPJaTmVUqUqQq54phhTysqajRksJsNGJLzPn61Ghqwn5tDrqWk5lVLlqkK+qYZU8rKmo0ZLCbDRIeDLZUaUoqNzqNDVhPz9XXUtJzKqXLVIV9Uwwp5WVNRoyWE2GhSwgXNTpZfX24Gs64TwZdCjxQIULinXUtJzKqXLVIV9dMKbAZzf3QtYQMyqmzS+bDjaGpmW612SadkOPG6z1wz9cdVrCBmNTZpfNhxsHdwv8AXHRawgZlVNml82HG6NnC/wBcU44ltOZVTJqpBt/mydQOxh7qW4uZVTJipCvrZJ2L68xtbZvt33L796vqvV9n/8QAKREAAQIFAwMFAQEBAAAAAAAAAQIDAAQREiAFMDEQIjITITNhcVEjQf/aAAgBAgEBPwHYui6KnCpi6Lt8q3ArbJpBNdhLiVkhJ4yBpANdgmmzPT1vYjmNJPlsA1yJpsz07b2I56aT5HZBriTXYnp23sRzFa9NK8jsg0wUdienbOxHME166V5nq/Nts+UNTzThoDkk7U7O+n2I5gmuGlNEArPScnQyLU8wpRUanpIPF1r3/wCZqznpv0k2p5gmuElJF43K4gAAUETk6Gu1PMKUVGp66T4nJMK5yWoISVGHnC6sqOElJl43K4gAJFBE7O+n2o5gmvucNJ8TkmDlqKrWThJyZeNTxCUhIoInZ30+xPME198dJ8TkOc9U+Lq0i9YTCEBCbRE86ttHZBSoxYr+QRTDSfE7uqfEP3qhRSbhEvNoeH3FyYuT0mZVDyfuCKddJ8Tu6p8Q/caw0hbirUww16SAmJh5LKLjBNT10nxOZy1T4h+4ttqcVamJWVSwn7h55LKbjExMKeVU4aci1nIcwrnLVPiH7g22pxVqYlZVLCfuHnkspqqJiYU8qpwYaLqwkQlISKDJMKy1T4h1bbU4q1MSsqlhP3DzyWU1MTEwp5VTglJUaCJOV9FPvzmnOcaLrRAginMNtqcVamJWVSwn76aksl6n8wQgqNBEnJhkVVztKGTso077qENS7bXiOuoD/c9UpKjQRJyYZFTzsJGBFNnUfnPRCSo0EScmGRU87AFcSK7Oo/OYQgrNBEpJhkVPOyBTIiuxPNqXM2piUlEsD72QKbBFYIplaK12AKwBTbKdwJ37YtMUwpFpi3Z//8QAMhAAAQICCAQGAQQDAAAAAAAAAQACERIQICEwMUBBcQMTMlAiUXKBkbFhM0JicCNggv/aAAgBAQAGPwL+0rP9CHC1+u48vh9f0gdYodv5fD6/pRKG6HbuXw+v6UTQENu2yM6/pRNITds3DIyM61E2mq0/jtcrD4yomszbtUrbXouNpNdm3aYC15UzjE3HD2qzPK/xtAC8QDgodLvLsEG2vOCLnGJNwE1vkKkzvYKZxpiFB3UM9KLX+SLnGJNzH9rbakzsdAp3mrbqM7Z1nBFzjEm5h+3UqVospi74UzqzN84XuRe65gMNSgxopicdAp3muz1DOcsHwtuYDDUoMbT/AC0CmcYm4Z6hm3PuZRhqVKwU/wAtFM423LPUM21lxK1StFPm7QIucYk3TPUM3/zXlaFK35pstcpnGJu2eoZs7VoDFQ1ONMBa8qLjE3jPUM2dqwjpbUcZSYr9N3wv03fC6HfC6HfC8TSLhnqGbO1ZrtNVEXEHNBU/DtZXZ6hmztXkfa1Ra8LqHyuofK6h8rqHyrKSDgnDyNZnqGbO16ST4ThTFOP5rM9QzZ2vJndH2oCnksx1Ndg/Mc2drud3R9qAwp5fDPi1Pko1/bNna6md0BQFgpPD4Z8WpVtw7ia4Zs7XMTYxStEBTy+H1am5AGqaz8Zs7XET0KVogKeXwz4tT5KJuee7AYZw7V4mxilaIAU8vhnxalRuYaalBjcBnPatE2MClaICnl8M+LUq25lapBnQ/QirE2MUrRAU/k2BRNzK33Urc9LrooOEDTE2MUrRACoze5lb7lStHYIPHuvBxPlR4jpvwoAQFVlxK3DUqVvaeHvXlb7lSt7UzetBuGpUrBmY5Jm9WAw1KkbkY5tm9SyxvmpG9tZvTD9upUrBAdu4e9Hk0YlBrBAdvYYYFeTdSgxogB3CVwiFKwADstn94f/EACcQAQABAgUFAAMBAQEAAAAAAAERADAhMUBBURAgYXGhgbHwkVDB/9oACAEBAAE/IdElvSNil15ql5e2XlrzUbxQNyht/wDhC3pdqVc2+IyaOZQ60RStKDzQOpPNSupYzxKDJptqjjqxjKp8HRuFN6aFPMphvN5lQyaBAS0y0JhSVm0QLKlNfJef0pCSXkBLTLQkiSs2jJFXNa+FXzX2VISS4sFMtC4SVm0SiSvT7Kcr4aCR4oZLc7DLQk7is2iIkrn1+qvkaGPBytbDQonFfKdOpmvZle68lDRSYNmHF0Bwz9VM0lc3tMzRmMM04Tp4WsLkcU6OYXuKISZaNEx3QGgwT5I4pMhM1uvhUlR3yLFr/HUivqFoYU38zjJOKWBmGwJDl7SBs0v5GlPpGx1JJCZNN4zfPm247Ki+miLlw80uLMLZIKRJPYrT9imEjg47QMolLinqeMXoXiyFLAzC2RREFBaMOqNsduVPX9HHc7TifbixTqss3dgowOazgnI4LIYoH4Ki5B96ysl/kprIX53/ANTmjK24D0cO97FHls5Xz+CjpgN+r7EXQ+clj+JzdUilkXcEJYwpxcbBwY/wUJiB968qeSnClWf4nN14JecBOMylgcXt4oLG5esDIW2AYfxObryVid1fD/3vD+88UQDHfl1gUFyKQqS3/E5u5VObdX+DuNFKYKM+UuvgmDimzE3bn8Tm7kXvhd3Go9iWiKRDbthClPqAWP4nN0zvfC7d6knw9KI0kcSxAUeqcgdzx3/xOdX8LvCxdvxU9s99trWsBKE8dRblGNGDkh3fxOdX8KzLy1Ly1Ly1Ly0NdtHqxVkY0BOSu7+ZzRcM6c7vwrhk0FBpgG3U0XFkbeO9xNj9XcijDu/CtmRgUEmAyOotOWRRKJle+aXDu5V5+FaSJT6UJMDI6jjJ/BSVKlbAzjND1dOahk3fhWSpoZvNBABkHUyvK/BSqystgQpVBRcJi93TgtGXd+FYIHAcXmhgAyDrDZyoJRJWyohCfm3hB6JDFz4HfjTDN5oZsAdRaUvwUlSZWyPMhxoHSAguiQdTErhh+T3eS4eaMADIOptOeRtSqypbIs/bxQPFc15vHGes1w8DCk9pw0HF5oIAMg6yaNaiJK2TR4buKAj7d2+IHYItjbIcV5pq8uesO0s13ocDIHZ9P9WTIYfgKMe889xZm7UkrkCc7bisTLOBQ1cHIQUNMGQdv0tgEX6FAz9vPeYEH/CiPq/rvKBh/gUHP286AzqgfT/XdH74CgfuPOgMWsIsbLRfT/Xbl3H4KOD7edWJXjQ/T/XZFcBnQwOBm86HMOVsSQ0y0H0/11g4QUDSBoWVBGVyJFBUN/6P66YcpRZA0LKgBBeIY0yvGBJi+MKjmI6IqSZUAINAAhpfS6zEmZUOK2DQ5hyoI0e7rBjW+6YaIalPCg1IHLDTIjxQPOtVS7Y0iZl8FyKXetk/4Sm1PBpqS2qHh7YeGhtqKDk0Bto//9oADAMBAAIAAwAAABDzzzzzzzK93+z7z819LzzzzzzzzzzzxrZz777777776zjbzzzzzzzzz+/7777777L77774/fzzzzzzz7z7777776Rz777776z7zzzzzbz7777776wLT7777776z/zzz5f7777777iAP777777777vbzyb7777777kEMMf77jP77777zzbz777776AIMMOv7sJJ/wC+++92j++++++1CDDDP+xgDDp+++++z3+++++6ADDDo/7DDDDo+++++5X+++++4DDDWduDDDDDo+++++7e+++++rDD3c6qMLDDDo+++++4++++++qDDQzgAF8DDDo++++++2+++++qDDDTBE2qDDDj+++++sX+++++qDDDDCf4rDDD2+++++vf+++++qDDDFV4DDDDS9+++++tP+++++tDDFN4rDDDAs++++++vv8APvvvuAhXfgAwwwzvstvvvuXvGvvvvvjfvvoAww/fvrnvvvvPPLt/vvvvvvvqQwx/vvvvvvr/ALzzxrz7777776kCX7777777wfzzzzzzz777776Gf7777777z7zzzzzzxrf77776/wC++++++3X888888888ua8+++++++++48+8888888888886r/z2+6773W8888888//EACgRAQABAgUDBAMBAQAAAAAAAAEAESAhMDFBYRBRsXGhweGBkfDR8f/aAAgBAwEBPxC+kHAyiyiUxcpm6w74FMpKx7csqgBkMADEc3IY0ZFSBTIwwcDvy8Qj9/i9KyhcKs0yMMPA78vEAChBgvX4yErBS0KGRgB4Hf6gCh0JU5clKlh3yGYfE7/UAdTGufjrimF3cCIq4bmP3cd+gVhhejA4nf6hnYsVTGpfzp00oH34P9gU6BECjHQ0WNqV6HG/Az5nt/sM7FlddX7cx0lVmnA+/p/sMHQOpK3DccYcLtUBaTRrP6tmsN+3LED1WMGGff6gAKBZ7RuOENLic7Fs1fvQ7csRvVYyBTz+oACgW+0btF+v6Px1Pt5Y+eqyhXgFad4HQP2TifuCa2PaNzf43yddEBKRkNWxP7CcTOBjU1gFVdxt/wBhkN+vtHN8b5LEGcUX4YTBmlYLD14O8Eht1BLcG80u8b5LU70CadBodvuBQx8cs3/bvewjGwLtEeF2v6PkserQ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"/>
                        <span class="text-slate-800 font-semibold hover:cursor-pointer hover:text-teal-700"
                              @click.stop="delegate('flint')"
                              x-show="walletService?.supports('flint')">
                            Flint
                        </span>
                        <span class="text-slate-300 text-sm 2xl:text-base"
                              x-show="!walletService?.supports('flint')">
                            Not Installed
                        </span>
                        <a href="//flint-wallet.com/"
                           target="_blank"
                           class="text-slate-400 text-xs flex flex-row gap-1 items-center"
                           x-show="!walletService?.supports('flint')">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-span-1 flex gap-3 justify-center items-center py-8 px-8 bg-slate-50">
                        <img alt="gerowallet wallet logo" class="max-h-8 2xl:max-h-12"
                             src="data:image/png;base64,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"/>
                        <span class="text-slate-800 font-semibold hover:cursor-pointer hover:text-teal-700"
                              @click.stop="delegate('gerowallet')"
                              x-show="walletService?.supports('gerowallet')">
                            Gero
                        </span>
                        <span class="text-slate-300 text-sm 2xl:text-base"
                              x-show="!walletService?.supports('gerowallet')">
                            Not Installed
                        </span>
                        <a href="//gerowallet.io"
                           target="_blank"
                           class="text-slate-400 text-xs flex flex-row gap-1 items-center"
                           x-show="!walletService?.supports('gerowallet')">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                 fill="currentColor">a
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-span-1 flex gap-3 justify-center items-center py-8 px-8 bg-slate-50">
                        <img alt="eternl wallet logo" class="max-h-8 2xl:max-h-12"
                             src="data:image/jpeg;base64,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"/>
                        <span class="text-slate-800 font-semibold hover:cursor-pointer hover:text-teal-700"
                              @click.stop="delegate('eternl')"
                              x-show="walletService?.supports('eternl')">
                            Eternl
                        </span>
                        <span class="text-slate-300 text-sm 2xl:text-base"
                              x-show="!walletService?.supports('eternl')">
                            Not Installed
                        </span>
                        <a href="//ccvault.io/"
                           target="_blank"
                           class="text-slate-400 text-xs flex flex-row gap-1 items-center"
                           x-show="!walletService?.supports('eternl')">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="col-span-1 flex gap-3 justify-center items-center py-8 px-8 bg-slate-50">
                        <img alt="typhon wallet logo" class="max-h-8 2xl:max-h-12"
                             src="data:image/svg+xml,%0A%3Csvg width='223' height='162' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M70.074 129.521c-.137.019-.265.104-.377.281-.447.712.663 7.403 3.85 11.024 3.187 3.633 10.236 2.358 15.139 3.127 4.902.768 6.794 4.467 10.093 9.226 5.08 8.257 12.252 8.457 12.252 8.457s7.172-.2 12.252-8.457c3.299-4.759 5.192-8.458 10.094-9.226 4.902-.769 11.954.506 15.141-3.127 3.187-3.621 4.296-10.312 3.849-11.024-.446-.711-1.151.053-1.68.657-2.286 2.613-3.445 4.361-8.666 5.777-5.22 1.417-10.388.07-10.388.07-2.256 1.993-4.104 3.381-8.381 3.526l-12.221.039-12.22-.039c-4.278-.145-6.124-1.533-8.38-3.526 0 0-5.168 1.347-10.388-.07-5.22-1.416-6.38-3.164-8.666-5.777-.396-.453-.891-.995-1.303-.938Z' fill='url(%23a)'/%3E%3Cpath d='M20.203.027c-9.581-1.351-56.658 48.398 37.71 81.68 9.755 3.445 31.74 9.444 39.077 22.048-5.155 1.156-8.527 1.875-14.375-.214-8.532-3.048-6.464-12.087-6.287-12.155L31.23 74.22s7.772 9.16 18.678 17.166c10.906 8.007 30.389 16.235 38.271 20.883 7.883 4.635 10.088 12.406 10.088 12.406s-2.368-.45-7.607-.595c-5.24-.145-10.149-3.561-11.293-6.655-1.144-3.093-.418-7.498-.461-7.584l-11.19-4.996s.001 7.772-2.267 10.325c-2.268 2.541-12.971-4.565-15.758-6.051-.832-.443-1.67-.318-1.52.683.138.907 5.394 8.664 10.153 12.903 4.746 4.226 10.858 2.747 12.303 2.691 2.354-.091 7.307.013 12.162 2.936 5.601 3.373 6.33 5.383 8.314 7.214 1.416 1.306 3.72 3.401 7.666 3.401l12.262.105 12.262-.105c3.946 0 6.252-2.095 7.668-3.401 1.983-1.831 2.713-3.841 8.314-7.214 4.855-2.923 9.808-3.027 12.162-2.936 1.445.056 7.557 1.535 12.303-2.691 4.759-4.239 10.013-11.996 10.15-12.903.151-1.001-.685-1.126-1.517-.683-2.787 1.486-13.49 8.592-15.758 6.051-2.268-2.553-2.268-10.325-2.268-10.325l-11.189 4.996c-.043.086.683 4.491-.461 7.584-1.144 3.094-6.056 6.51-11.295 6.655-5.239.145-7.605.595-7.605.595s2.205-7.771 10.087-12.406c7.883-4.648 27.365-12.876 38.272-20.883 10.906-8.006 18.676-17.166 18.676-17.166l-45.096 17.166c.177.068 2.245 9.107-6.287 12.155-5.848 2.089-9.22 1.37-14.375.214 7.337-12.604 29.322-18.603 39.076-22.048C261.563 47.352 208.257-4.551 201.056.32c-2.119 1.438-.619 3.63-.619 3.63s7.312 12.196 1.686 23.325c-5.627 11.13-28.788 17.534-36.918 16.654-8.093-.867-11.524-3.426-11.549-3.488-2.85-3.619-6.115-10.174-11.543-6.432-6.383 4.413-13.658 3.016-19.223-3.007-5.577-6.036-11.859-8.383-11.859-8.383s-6.282 2.347-11.86 8.383c-5.564 6.023-12.84 7.42-19.222 3.007-5.428-3.742-8.69 2.813-11.541 6.432-.025.062-3.456 2.62-11.549 3.488-8.13.88-31.291-5.524-36.918-16.654-5.626-11.129 1.686-23.324 1.686-23.324s1.498-2.193-.621-3.631a1.882 1.882 0 0 0-.803-.293Zm49.013 53.61s6.384-.113 17.29 3.134C97.4 60.02 111.03 73.03 111.03 73.03s13.633-13.01 24.527-16.258c10.906-3.247 17.289-3.135 17.289-3.135s-14.501 3.135-26.56 10.67-15.256 16.819-15.256 16.819-3.197-9.284-15.256-16.819c-12.059-7.535-26.559-10.67-26.559-10.67Z' fill='url(%23b)'/%3E%3Cpath d='M18.434.23C6.126 3.813-31.55 50.155 57.914 81.707c9.754 3.445 31.74 9.445 39.076 22.048-5.154 1.157-8.526 1.875-14.374-.214-8.532-3.048-6.464-12.087-6.288-12.155L31.231 74.22s7.771 9.16 18.677 17.166c10.907 8.007 30.39 16.235 38.272 20.883 7.882 4.635 10.088 12.406 10.088 12.406s-2.368-.45-7.608-.595c-5.239-.145-10.148-3.561-11.292-6.655-1.145-3.094-.418-7.499-.461-7.586l-11.19-4.994s0 7.771-2.267 10.325c-2.269 2.541-12.971-4.565-15.758-6.051-.832-.443-1.67-.318-1.52.683.137.907 5.393 8.664 10.153 12.903 4.746 4.226 10.857 2.747 12.302 2.691 2.354-.092 7.306.012 12.16 2.936 5.602 3.373 6.333 5.383 8.317 7.214 1.415 1.306 3.72 3.401 7.666 3.401l12.172.105h.09l12.171-.105c3.946 0 6.251-2.095 7.666-3.401 1.984-1.831 2.715-3.841 8.317-7.214 4.854-2.924 9.806-3.028 12.16-2.936 1.445.056 7.558 1.535 12.305-2.691 4.759-4.239 10.013-11.996 10.15-12.903.151-1.001-.687-1.126-1.519-.683-2.787 1.486-13.49 8.592-15.758 6.051-2.268-2.554-2.268-10.325-2.268-10.325l-11.189 4.994c-.044.087.683 4.492-.461 7.586-1.144 3.094-6.054 6.51-11.293 6.655-5.239.145-7.608.595-7.608.595s2.208-7.771 10.09-12.406c7.883-4.648 27.363-12.876 38.27-20.883 10.906-8.005 18.677-17.166 18.677-17.166l-45.097 17.166c.177.068 2.244 9.107-6.287 12.155-5.849 2.089-9.221 1.371-14.375.214 7.336-12.603 29.322-18.603 39.076-22.048C253.523 50.155 215.849 3.813 203.541.23c0 0 12.481 16.237 10.574 32.127-1.849 15.89-33.283 31.897-59.632 38.37-7.43 1.827-42.266 16.833-43.483 33.773-1.217-16.94-36.08-31.946-43.51-33.774C41.142 64.254 9.71 48.247 7.86 32.357 5.953 16.467 18.434.23 18.434.23Z' fill='url(%23c)'/%3E%3Cpath d='M98.806 139.832c-.638 10.773 12.225 17.297 12.225 17.297s12.865-6.524 12.226-17.297l-12.226.039-12.225-.039Z' fill='url(%23d)'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M94.539 120.953c-.607-1.456-3.899-7.209-11.557-9.451-.84-.246-2.196-.404-2.534 1.532-.297 1.702.27 3.93 1.313 5.28 1.908 2.468 4.083 3.58 6.755 4.09 1.141.217 2.812.569 4.226.471a3.829 3.829 0 0 0 1.549-.422c.645-.328.54-.8.248-1.5ZM92.99 101.338c-2.033-2.331-4.865-6.195-12.313-8.99-.82-.309-2.196-.404-2.534 1.532-.297 1.702.27 3.93 1.314 5.28 1.907 2.468 4.078 3.604 6.754 4.09 1.2.217 2.16.473 4.226.471.577-.001 1.163-.104 1.698-.2 2.047-.367 1.544-1.393.855-2.183ZM127.525 120.953c.607-1.456 3.899-7.209 11.557-9.451.841-.246 2.196-.404 2.534 1.532.297 1.702-.269 3.93-1.313 5.28-1.907 2.468-4.083 3.58-6.754 4.09-1.142.217-2.813.569-4.226.471a3.832 3.832 0 0 1-1.55-.422c-.645-.328-.539-.8-.248-1.5ZM129.073 101.338c2.034-2.331 4.866-6.195 12.313-8.99.821-.309 2.197-.404 2.535 1.532.297 1.702-.27 3.93-1.314 5.28-1.907 2.468-4.078 3.604-6.754 4.09-1.2.217-2.161.473-4.226.471-.577-.001-1.163-.104-1.699-.2-2.046-.367-1.543-1.393-.855-2.183Z' fill='%236E93E5'/%3E%3Cpath d='M18.229 22.335s-.904 24.948 35.992 27.948c4.522.385 9.432-.141 13.77-4.623 6.547-6.766 5.935-8.502 10.31-6.817 4.387 1.686 10.139 3.754 16.77-2.133 6.629-5.874 10.222-7.232 15.96-7.232 5.738 0 9.333 1.358 15.963 7.233 6.631 5.886 12.382 3.818 16.77 2.132 4.374-1.685 3.763.051 10.31 6.817 4.338 4.482 9.247 5.008 13.77 4.623 36.895-3 35.99-27.948 35.99-27.948a19.416 19.416 0 0 1-1.709 4.944c-5.626 11.129-28.765 14.441-36.896 13.572-8.092-.865-8.011-3.927-10.584-8.23-2.69-4.498-7.101-4.239-12.53-.496-6.382 4.412-13.683 2.554-19.248-3.47-5.577-6.035-11.836-6.036-11.836-6.036s-6.257.001-11.834 6.037c-5.564 6.023-12.865 7.88-19.248 3.469-5.429-3.743-9.84-4.002-12.53.496-2.573 4.303-2.493 7.365-10.585 8.23-8.131.87-31.268-2.443-36.895-13.572a19.396 19.396 0 0 1-1.71-4.944Z' fill='url(%23e)'/%3E%3Cdefs%3E%3ClinearGradient id='a' x1='68.192' y1='146.036' x2='154.072' y2='146.036' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%233B60B2'/%3E%3Cstop offset='.497' stop-color='%233B60B2'/%3E%3Cstop offset='.499' stop-color='%234A78DF'/%3E%3Cstop offset='1' stop-color='%234A78DF'/%3E%3C/linearGradient%3E%3ClinearGradient id='b' x1='202.037' y1='49.094' x2='19.877' y2='49.094' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%23253C70'/%3E%3Cstop offset='.499' stop-color='%2334549C'/%3E%3Cstop offset='.5' stop-color='%233B60B2'/%3E%3Cstop offset='1' stop-color='%232C4886'/%3E%3C/linearGradient%3E%3ClinearGradient id='c' x1='184.305' y1='89.748' x2='40.983' y2='89.748' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%2334549C'/%3E%3Cstop offset='.512' stop-color='%23436CC9'/%3E%3Cstop offset='.512' stop-color='%234A78DF'/%3E%3Cstop offset='1' stop-color='%233B60B2'/%3E%3C/linearGradient%3E%3ClinearGradient id='d' x1='96.933' y1='144.58' x2='125.495' y2='144.728' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%23436CC9'/%3E%3Cstop offset='.494' stop-color='%23436CC9'/%3E%3Cstop offset='.494' stop-color='%234A78DF'/%3E%3Cstop offset='1' stop-color='%234A78DF'/%3E%3C/linearGradient%3E%3ClinearGradient id='e' x1='23.866' y1='22.619' x2='197.457' y2='22.619' gradientUnits='userSpaceOnUse'%3E%3Cstop stop-color='%231E3059'/%3E%3Cstop offset='.502' stop-color='%232C4886'/%3E%3Cstop offset='.502' stop-color='%23253C70'/%3E%3Cstop offset='1' stop-color='%23162443'/%3E%3C/linearGradient%3E%3C/defs%3E%3C/svg%3E"/>
                        <span class="text-slate-800 font-semibold hover:cursor-pointer hover:text-teal-700"
                              @click.stop="delegate('typhoncip30')"
                              x-show="walletService?.supports('typhoncip30')">
                            Typhon
                        </span>
                        <span class="text-slate-300 text-sm 2xl:text-base"
                              x-show="!walletService?.supports('typhoncip30')">
                            Not Installed
                        </span>
                        <a href="//typhonwallet.io/#/"
                           target="_blank"
                           class="text-slate-400 text-xs flex flex-row gap-1 items-center"
                           x-show="!walletService?.supports('typhoncip30')">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fixed bottom-4 w-full bg-transparent z-40 pointer-events-none">
        <x-notice/>
    </section>
</div>
