<x-public-layout class="home">

    <section class="">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 lg:gap-x-12">
                <!-- Left blob -->
                <div class="z-0 py-12 lg:py-16 lg:col-span-2 lg:pr-16 2xl:pr-32">
                    <x-public.tagline-pool-id-tool></x-public.tagline-pool-id-tool>
                </div>
                <div class="z-0 hidden w-full h-full py-0 pt-48 lg:block">
                    <div class="relative w-full h-full p-8 top-24 bg-gray-50 text-md md:text-sm xl:text-lg">
                        {{$snippets->homeOne}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  BLOCKCHAIN TECHNOLOGY --}}
    <section
        class="bg-teal-600">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 lg:gap-x-12">
                <!-- Left blob -->
                <div class="py-12 lg:py-16 lg:col-span-2 lg:pr-8 xl:pr-16 2xl:pr-32">
                    <div class="relative grid md:grid-cols-4">
                        <div class="w-48 mr-auto text-white md:w-52 lg:w-48 xl:w-68">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-[8rem] w-[8rem] sm:h-[11rem] sm:w-[11rem] md:w-[9rem] md:h-[9rem] mb-4 md:mb-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </div>
                        <div class="text-white md:col-span-3">
                            <div class="text-right">
                                <div class="text-3xl font-bold uppercase sm:text-3xl xl:text-4xl">
                                    {{$snippets->blockchainTechnology}}
                                </div>
                                <div class="text-sm font-semibold uppercase md:tracking-widest xl:text-base">
                                    {{$snippets->isTheFutureOfDecentralizedRecordKeeping}}
                                </div>
                            </div>
                            <div class="flex flex-row flex-wrap justify-end gap-3 mt-5 text-right">
                                <div
                                    class="inline-flex flex-col justify-center text-gray-200 bg-gradient-to-r shape morph-2 from-primary-100 to-primary-300">
                                    <dt class="inline-block p-2 text-sm font-extrabold xl:p-4 md:text-base xl:text-lg">
                                        {{$snippets->finance}}
                                    </dt>
                                </div>
                                <div
                                    class="inline-flex flex-col justify-center text-gray-200 bg-gradient-to-r shape morph-2 from-primary-100 to-primary-300">
                                    <dt class="inline-block p-2 text-sm font-extrabold xl:p-4 md:text-base xl:text-lg">
                                        {{$snippets->property}}
                                    </dt>
                                </div>
                                <div
                                    class="inline-flex flex-col justify-center text-gray-200 bg-gradient-to-r shape morph-2 from-primary-100 to-primary-300">
                                    <dt class="inline-block p-2 text-sm font-extrabold xl:p-4 md:text-base xl:text-lg">

                                        {{$snippets->identity}}
                                    </dt>
                                </div>
                                <div
                                    class="inline-flex flex-col justify-center text-gray-200 bg-gradient-to-r shape morph-2 from-primary-100 to-primary-300">
                                    <dt class="inline-block p-2 text-sm font-extrabold xl:p-4 md:text-base xl:text-lg">
                                        {{$snippets->contracts}}
                                    </dt>
                                </div>
                                <div
                                    class="inline-flex flex-col justify-center text-gray-200 bg-gradient-to-r shape morph-2 from-primary-100 to-primary-300">
                                    <dt class="inline-block p-2 text-sm font-extrabold xl:p-4 md:text-base xl:text-lg">
                                        {{$snippets->governing}}
                                    </dt>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right blob -->
                <div class="relative hidden w-full h-full py-0 pt-16 lg:block">
                    <div class="w-full h-full p-8 bg-gray-50 text-md md:text-sm xl:text-lg">
                        {{$snippets->homeTwo}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  Cryptocurrency is growing --}}
    <section class="bg-accent-200">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 lg:gap-x-12">
                <!-- Left blob -->
                <div class="py-12 lg:py-16 lg:col-span-2 lg:pr-8 xl:pr-16 2xl:pr-32">
                    <div class="relative z-10 grid md:grid-cols-4">
                        <div class="flex flex-col justify-center gap-3 md:col-span-3">
                            <h3 class="text-3xl font-bold uppercase sm:text-4xl">
                                {{$snippets->cryptocurrencyIsGrowing}}
                            </h3>
                            <h4 class="font-semibold">
                                {{$snippets->youCanBeAPartOfIt}}
                            </h4>

                            <p class="">
                                {{$snippets->cryptoNotForTechies}}
                            </p>
                        </div>
                        <div class="flex flex-row justify-end mt-3 text-teal-600">
                            <div class="w-48 ml-auto md:w-52 xl:w-68">
                                @include('svg.chart-up')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right blob -->
                <div class="relative hidden w-full h-full py-0 pb-8 lg:block">
                    <div class="relative w-full p-8 -top-9 bg-gray-50 text-md md:text-sm xl:text-lg">
                        <p>
                            <b>
                                {{$snippets->investInAda}}
                            </b>
                            {{$snippets->rewardsTowards}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  CARDANO (ADA) --}}
    <section class="overflow-x-hidden bg-teal-600">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                <!-- Left blob -->
                <div class="py-12 lg:py-16 lg:col-span-2 lg:pr-8 xl:pr-16 2xl:pr-32">
                    <div class="z-10 grid md:grid-cols-4">
                        <div class="flex flex-row justify-start text-white mb-11">
                            <div class="w-48 mr-auto md:w-52 xl:w-68">
                                @include('svg.cardano')
                            </div>
                        </div>
                        <div class="grid gap-3 pl-8 ml-auto text-white md:col-span-3 lg:relative lg:-right-24 lg:pr-28">
                            <div class="text-3xl font-bold uppercase sm:text-4xl">
                                {{$snippets->cardano}} ({{$snippets->ada}})
                            </div>
                            <p class="font-semibold">
                                {{$snippets->isABlockchainPlatformAndCryptocurrency}}
                            </p>
                            {{$snippets->cardanoWasDeveloped}}

                            {{$snippets->cardanoIsUniquelySecure}}

                            <p class="lg:hidden">
                                <x-public.continue-reading theme="accent" route='what-is-cardano'></x-public.continue-reading>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Right blob -->
                <div class="relative z-20 hidden w-full h-full py-8 lg:block">
                    <div class="w-full h-full p-8 bg-no-repeat bg-cover bg-gray-50"
                        style="background-image: url('/img/what-is-cardano-full-thumbnail.jpg')">
                        <div class="w-full h-full p-6 bg-white filter text-md md:text-sm 2xl:text-md blur-smhover:blur-0">
                            <h3 class="text-3xl font-semibold hover:text-teal-600">
                                <a class="capitalize" href="{{route("what-is-cardano")}}">
                                    {{$snippets->whatIsCardano}}
                                </a>
                            </h3>
                            <p>
                                {{$snippets->cardanoIsABlockchainPlatformThatSolvesRealProblemsInOurWorld}}
                            </p>
                            <ul class="ml-8 list-disc list-outside">
                                <li>
                                    {{$snippets->financialTransactionsThatAreFastSecureAndAffordable}}
                                </li>
                                <li>{{$snippets->contractsAndDeedsThatAreSmartSimpleAndFreeOfRedTape}}
                                </li>
                                <li>
                                    {{$snippets->identityAndPersonalRecordsThatAreGlobalPrivateAndSafe}}
                                </li>
                                <li>
                                    {{$snippets->equitableAndAccessibleGovernmentAndVoting}}
                                </li>
                            </ul>
                            <p>
                                <x-public.continue-reading theme="primary" route='what-is-cardano'></x-public.continue-reading>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  LIDONATION --}}
    <section class="overflow-x-hidden bg-white">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                <!-- Left blob -->
                <div class="py-12 lg:py-16 lg:col-span-2 lg:pr-8 xl:pr-16 2xl:pr-32">
                    <div class="grid md:grid-cols-4 lg:gap-x-18">
                        <div class="flex flex-col justify-center md:col-span-3">
                            <h3 class="text-3xl font-bold sm:text-4xl">
                                {{$snippets->lIDONation}}
                            </h3>
                            <p class="font-semibold uppercase">
                                {{$snippets->isACardanoStakingPool}}
                            </p>
                            <p>
                                {{$snippets->learnHowToBuyADAAndGrowYourInvestment}}
                            </p>
                            <p>
                                {{$snippets->ourPoolTickerIsLIDO}}
                            </p>
                        </div>
                        <div class="flex flex-row justify-end mt-11 md:mt-0">
                            <div class="w-48 ml-auto md:w-52 xl:w-68">
                                <img class="object-cover responsive xl:min-w-68"
                                    src="{{asset('img/llogo-transparent.png')}}" alt="{{$snippets->lIDONationWhiteLogo}}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right blob -->
                <div class="relative z-20 hidden w-full h-full py-0 pt-16 lg:block">
                    <div class="w-full h-full p-6 pb-0 bg-gray-50">
                        <div class="w-full h-full p-6 bg-white filter text-md md:text-sm 2xl:text-md blur-smhover:blur-0">
                            <h3 class="text-3xl font-semibold hover:text-teal-600">
                                <a class="capitalize" href="{{localizeRoute('what-is-staking')}}">
                                    {{$snippets->whatIsStaking}}
                                </a>
                            </h3>
                            <p>
                                {{$snippets->cardanoUsesANetworkOfStakingPoolsToOperate}}
                            </p>
                            <ul class="ml-8 list-disc list-outside">
                                <li>
                                    {{$snippets->poolsValidateNetworkTransactions}}
                                </li>
                                <li>
                                    {{$snippets->sharedResponsibilityCreatesASecureNetwork}}
                                </li>
                                <li>
                                    {{$snippets->poolOperatorsAndDelegatorsReceiveRewardsForParticipation}}
                                </li>
                            </ul>
                            <p>
                                <x-public.continue-reading theme="primary" route='what-is-staking'></x-public.continue-reading>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  STAKING POOLS --}}
    <section class="overflow-x-hidden bg-teal-600">
        <div class="container">
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                <!-- Left blob -->
                <div class="py-12 text-black lg:py-16 lg:col-span-2 xl:pr-16 2xl:pr-32">
                    <div class="relative z-10 grid text-white md:grid-cols-4">
                        <div class="flex flex-row justify-start mb-11">
                            <div class="w-36 md:w-44">
                                @include('svg.pool-network')
                            </div>
                        </div>
                        <div class="flex flex-col pl-8 ml-auto md:col-span-3 lg:relative lg:-right-24 lg:pr-28">
                            <h3 class="text-3xl font-bold uppercase sm:text-4xl">
                                {{$snippets->stakingPools}}
                            </h3>
                            <p class="font-semibold uppercase">
                                {{$snippets->stakedTokensEarnRewards}}
                            </p>
                            <p>
                                {{$snippets->stakedTokensGrow}}
                            </p>
                            <p class="xl:hidden">
                                <x-public.continue-reading theme="accent" route='what-is-staking'></x-public.continue-reading>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Right blob -->
                <div class="relative z-20 hidden w-full h-full py-0 pb-8 lg:block">
                    <div class="grid w-full gap-3 p-6 pt-3 bg-gray-50 xl:grid-cols-2">
                        <div class="flex flex-col p-2 bg-white">
                            <h3 class="text-xl font-semibold hover:text-teal-600">
                                <a href="{{route("how-to-buy-ada")}}">
                                    {{$snippets->howToBuyADA}}

                                </a>
                            </h3>
                            <div class="text-md md:text-sm 2xl:text-md">
                                <p>
                                    {{$snippets->beginnerFriendlyInstructionsForBuyingADAUsingYourMobileDeviceOrComputer}}
                                </p>
                            </div>
                            <div class="mt-auto text-sm">
                                <x-public.continue-reading theme="primary" route='how-to-buy-ada'></x-public.continue-reading>
                            </div>
                        </div>
                        <div class="flex flex-col p-2 bg-white">
                            <h3 class="text-xl font-semibold hover:text-teal-600">
                                <a href="{{route("how-to-stake-ada")}}">
                                    {{$snippets->howToStake}}
                                </a>
                            </h3>
                            <div class="text-md md:text-sm 2xl:text-md">
                                <p>
                                    {{$snippets->easy123ProcessOnHowToStakeYourADAAndEarn}}
                                    {{$snippets->rewardsGetPaidEveryFiveDays}}
                                </p>
                            </div>
                            <div class="mt-auto text-sm">
                                <x-public.continue-reading theme="primary" route='how-to-stake-ada'></x-public.continue-reading>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--Our Community--}}
    <section
        class="relative py-12 overflow-x-hidden bg-fixed bg-scroll bg-center bg-blend-soft-light lg:py-28 bg-lido-nature lg:bg-bottom bg-primary-600"
        aria-labelledby="quick-links-title">
        <div class="container">
            <div class="bg-gray-800 opacity-75 px-8 py-12 max-w-[94%] lg:max-w-full mx-auto">
                <div class="mb-1 mb-12 text-3xl font-extrabold text-white uppercase sm:text-4xl xl:text-7xl">
                    {{$snippets->ourCommunity}}
                </div>
                <div class="grid gap-3 pr-4 font-bold text-white xl:text-3xl">
                    <p class="">
                        {{$snippets->fourPercentRewards}}
                    </p>
                    <p>
                        {{$snippets->nominateAndVote}}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{--Library--}}
    <section class="overflow-x-hidden border-b">
        <x-public.library-drip :posts="$posts"></x-public.library-drip>
    </section>
</x-public-layout>
