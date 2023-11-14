<div
    class="bg-gradient-to-l phuffycoin phuffycoin-home md:bg-gradient-to-bl from-primary-500via-primary-800to-primary-900 bg-primary-1000 md:bg-no-repeat">

    <div class="sticky top-0 z-10 border-b bg-primary-1000 page-nav border-primary-900">
        <div class='container'>
            <nav class="justify-end flexflex-row">
                <ul class="flex flex-row justify-end gap-2 text-sm">
                    <li class="flow-root menu-item">
                        <a href="#phuffycoin" class="flex text-white menu-link">
                                <span class="px-1 py-3">
                                    {{ $snippets->top}}
                                </span>
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a href="#current-campaign" class="flex text-white menu-link">
                                <span class="px-1 py-3">
                                    {{ $snippets->causes}}
                                </span>
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a href="#faqs" class="flex text-white menu-link">
                                <span class="px-1 py-3">
                                    {{ $snippets->fAQs}}
                                </span>
                        </a>
                    </li>
                    <li class="flow-root menu-item">
                        <a href="{{localizeRoute('phuffycoin.phuffycoin-roadmap')}}" class="flex text-white menu-link">
                                <span class="px-1 py-3">
                                    {{ $snippets->roadmap}}
                                </span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <section id="phuffycoin" class="relative text-white bg-transparent section-1 lg:text-xl">
        <div class="container relative pt-12 pb-24 md:pt-20 md:pb-20">
            <div class="flex flex-col items-center gap-12 md:gap-6 md:gap-0 md:flex-row">
                <div>
                    <h1 class="z-10 text-5xl md:text-6xl">PHUFFY Coin <b></b></h1>
                    <div class="z-10 flex flex-col max-w-3xl gap-6">
                        <div>
                            <p>
                                The future is for everyone - and you can help shape it.
                            </p>
                        </div>

                        <div>
                            <p>
                                LIDO Nation mints and distributes PHUFFY coin as a perk for our delegators.
                                Using PHUFFY coin, delegators like you direct our pool's charitable giving.
                            </p>
                        </div>

                        <div>
                            <p>
                                Blockchain technology creates new opportunities for decentralized decision-making,
                                shared power - and shared responsibility.
                                PHUFFY Coin is free to use, and is a fun way to learn about blockchain concepts like
                                wallets, addresses, NFTs and more.
                            </p>
                        </div>

                        <div>
                            <p>
                                All while doing some actual good in the world!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="relative flex items-center justify-center border-0 rounded-sm bg-clip-border card">
                        <div
                            class="relative flex flex-col overflow-hidden rounded-full shadow w-80 h-80 from-primary-500 via-primary-800 to-primary-900"
                            x-data="{
                                pulse:true,
                                init() {
                                    setTimeout(() => {
                                        this.pulse = false;
                                    }, 525);

                                }
                            }" :class="{'animate-bounce': pulse}">
                            <div
                                class="relative flex items-center justify-center font-extrabold rounded-full w-96 h-96 text-teal-600">
                                <div class="relative inline-block rounded-full -top-3 w-96 h-96">
                                    @include('svg.phuffycoin-logo')
                                </div>
                            </div>
                            <div class="text-6xl font-extrabold text-black md:text-7xl">

                            </div>
                            <p class="text-black">PHUFFY Minted to date</p>
                            <div
                                style="top: calc(100% - 0.05rem); clip-path: polygon(0 0,5% 100%,95% 100%,100% 0);"
                                class="absolute left-0 right-0 h-12 bg-gradient-to-b to-transparent from-primary-500"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section
        class="relative pb-16 text-white border-t-2border-whiteborder-dashed bg-primary-1000 section-2-DISABLED lg:text-xl">
        <div class="container">
            <div>
                <h2 class="z-10 mb-1 text-4xl uppercase md:text-5xl">How to participate</h2>
                <div class="grid grid-cols-1 text-black lg:grid-cols-2">
                    <div x-data="{
                        module: $persist(null).using(sessionStorage)
                    }" class="flex flex-col w-full h-full min-h-[26rem] text-white bg-teal-600">
                        <div class="flex flex-col items-start justify-between h-full gap-6 p-6 md:p-12 mx:px-16"
                             x-show="module === null" @closemodule.window="module=null" x-transition>
                            <div class="flex flex-row items-center justify-between w-full gap-2 text-right">
                                @if($user?->has_lido_nft)
                                    <div class="flex items-start flex-shrink-0 text-left md:h-12 md:w-20">
                                        <span
                                            class="text-3xl font-extrabold leading-none text-white md:text-5xl font-display">1</span>
                                    </div>
                                @else
                                    <div class="flex items-start flex-shrink-0 text-left md:h-20 md:w-20">
                                        <span
                                            class="font-extrabold leading-none text-white text-7xl font-display">1</span>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-5xl font-bold">
                                        @if($user?->has_lido_nft)
                                            <span class="text-2xl md:text-4xl">You're Delegated!</span>
                                        @else
                                            Delegate
                                        @endif
                                    </h3>
                                </div>
                            </div>
                            @if(!$user?->has_lido_nft)
                                <div class="flex items-center md:max-w-xs lg:max-w-none">
                                    <div class="flex flex-col flex-auto gap-2">
                                        <div class="text-xl">
                                            Delegate your ADA to the LIDO Nation staking pool!
                                        </div>
                                        <div class="text-xl">
                                            There is no cost to stake - in fact your delegation earns passive rewards
                                            every time our pool mints a block on the Cardano network.

                                        </div>
                                        <div class="text-xl">
                                            <a class="text-white hover:text-gray-300"
                                               href="{{route('how-to-stake-ada')}}">
                                                Learn more about staking HERE
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="#stakeWithLido" @click="module = 'delegation'"
                                   class="flex flex-row items-center justify-between w-full mt-auto text-2xl font-extrabold text-white uppercase hover:text-gray-300 md:text-3xl">
                                    <span class="font-display">
                                        Stake with LIDO
                                    </span>

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @else
                                <div class="w-full">
                                    <div class="p-4 bg-black bg-opacity-40">
                                        <h3>
                                            <span>Thanks for trusting us with your delegation</span>
                                            @if($user->meta_data->delegation_length > 0)
                                                <span>
                                                for <span
                                                        class="text-2xl font-bold text-phuffy-500">{{$user->meta_data->delegation_length}}</span> Epochs
                                            </span>
                                            @endif
                                            <span>!</span>
                                        </h3>
                                        @if($txs)
                                            <hr class="w-full my-3 border-t border-b-0 border-gray-300 border-opacity-50"/>
                                            <div
                                                class="w-full overflow-auto text-white bg-gray-900 bg-opacity-25 rounded-md">
                                                <div class="rounded-tl-sm rounded-tr-md bg-primary-900">
                                                    <h3 class="py-2 text-xl font-semibold md:text-3xl">
                                                        <span>Awesome Rewards</span>
                                                        @if($txs)
                                                            <span class="text-lg md:text-xl text-phuffy-500">
                                                        {{humanNumber($rewards_aggregate?->sum?->amount / 1000000, 2)}} ₳
                                                    </span>
                                                        @endif
                                                    </h3>
                                                </div>
                                                <div>
                                                    <div class="flex flex-col">
                                                        <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                            <div
                                                                class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                                <x-portal.txs-table
                                                                    :txs="$txs->filter(fn($tx) => $tx->type === 'reward' )"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Learning Module -->
                        <div class="w-full h-full" x-show="module === 'delegation'" x-transition>
                            <livewire:learning-modules.delegation-learning-module-component/>
                        </div>
                    </div>

                    <div
                        class="flex flex-col items-start justify-between w-full gap-3 p-6 md:p-12 md:px-16 text-primaray-1000 bg-phuffy2-500">
                        <div class="flex flex-row items-center justify-between w-full gap-2 text-right">
                            @if($user?->has_lido_nft)
                                <div class="flex items-start flex-shrink-0 text-left md:h-12 md:w-20">
                                    <span
                                        class="text-5xl font-extrabold leading-none text-gray-800 font-display">2</span>
                                </div>
                            @else
                                <div class="flex items-start flex-shrink-0 text-left md:h-20 md:w-20">
                                    <span
                                        class="font-extrabold leading-none text-gray-600 text-7xl mix-blend-multiply font-display">
                                        2
                                    </span>
                                </div>
                            @endif

                            <div>
                                <h3 class="text-3xl font-bold md:text-5xl vertical-align">
                                    @if($user?->has_lido_nft)
                                        <span class="text-2xl mx:text-3xl">Thanks for Registering!</span>
                                    @else
                                        Register
                                    @endif
                                </h3>
                            </div>
                        </div>
                        @if(!$user?->has_lido_nft)
                            <div class="flex items-center md:max-w-xs lg:max-w-none">
                                <div class="flex flex-col flex-auto gap-2">
                                    <div class="text-xl text-gray-800">
                                        Registration is a 1-time process where we validate your stake in the LIDO nation
                                        pool.
                                    </div>
                                    <div class="flex flex-col gap-1 text-xl text-gray-800">
                                        Simply send 1.681A to a secure address.
                                    </div>
                                    <div class="text-xl text-gray-800">
                                        You will get your money back, plus the processing fee, and a LIDO NFT!
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('register')}}"
                               class="flex flex-row items-center justify-between w-full mt-auto text-2xl font-extrabold text-black uppercase hover:text-gray-700 md:text-3xl">
                                <span class="font-display">
                                    Validate wallet
                                </span>

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        @else
                            <div>
                                <h3 class="text-4xl md:text-5xl">
                                    and joining <span class="font-bold text-phuffy-800">{{$registeredUsers}}</span>
                                    registered PHUFFY Coiners using
                                    the blockchain to support causes in their communities!
                                </h3>
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex flex-col items-start justify-between w-full gap-3 p-6 md:p-12 md:px-16 text-teal-900 bg-phuffy-500">
                        <div class="flex flex-row items-center justify-between w-full gap-2 text-right">
                            @if($user?->has_lido_nft)
                                <div class="flex items-start flex-shrink-0 text-left md:h-12 md:w-20">
                                    <span
                                        class="text-3xl font-extrabold leading-none text-gray-600 md:text-5xl mix-blend-multiply font-display">3</span>
                                </div>
                            @else
                                <div class="flex items-start flex-shrink-0 text-left md:h-20 md:w-20">
                                    <span
                                        class="font-extrabold leading-none text-gray-600 text-7xl mix-blend-multiply font-display">3</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-5xl font-semibold text-right">
                                    @if($user?->has_lido_nft)
                                        <span class="text-2xl md:text-3xl">You have PHUFFIES!</span>
                                    @else
                                        Get Phuffy
                                    @endif
                                </h3>
                            </div>
                        </div>
                        @if(!$user?->has_lido_nft)
                            <div class="flex items-center md:max-w-xs lg:max-w-none">
                                <div class="flex flex-col flex-auto gap-2">
                                    <div class="text-xl">
                                        When we mint blocks you get:
                                    </div>
                                    <div class="flex flex-col gap-1 text-xl font-semibold">
                                        <span>1) your normal ADA rewards </span>
                                        <span>PLUS</span>
                                        <span>2) PHUFFY Coins!</span>
                                    </div>
                                    <div>
                                        You don't have to do anything to get new PHUFFY, they will be automatically
                                        added to your wallet.
                                    </div>
                                </div>
                            </div>
                            <a href="#current-campaign"
                               class="flex flex-row items-center justify-between w-full h-16 mt-auto text-2xl font-extrabold text-black uppercase hover:text-gray-500 md:text-3xl">
                                <span class="font-display">
                                    View your balance
                                </span>

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        @else
                            <div class="w-full">
                                @if($wallets?->user?->phuffy?->txs)
                                    <div class="text-white bg-gray-900 bg-opacity-25 rounded-md">
                                        <div class="rounded-tl-sm rounded-tr-md bg-primary-900">
                                            <h3 class="p-3 text-xl font-semibold md:text-3xl">
                                                <span>Phuffy Transactions</span>
                                                <span class="text-xl text-phuffy-500">
                                                {{humanNumber($wallets?->user?->phuffy?->txs->sum('quantity'))}}
                                            </span>
                                            </h3>
                                        </div>
                                        <div class="flex flex-col bg-gray-700">
                                            <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                    <x-portal.txs-table :txs="$wallets?->user?->phuffy?->txs"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex flex-col items-start justify-between w-full gap-3 p-6 text-white bg-gray-700 md:p-12 md:px-16">
                        <div class="flex flex-row items-center justify-between w-full gap-2 text-right">
                            @if($user?->has_lido_nft)
                                <div class="flex items-start flex-shrink-0 text-left md:h-12 md:w-20">
                                    <span class="text-5xl font-extrabold leading-none text-white font-display">4</span>
                                </div>
                            @else
                                <div class="flex items-start flex-shrink-0 text-left md:h-20 md:w-20">
                                    <span class="font-extrabold leading-none text-white text-7xl font-display">4</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-5xl font-semibold text-right">
                                    @if($user?->has_lido_nft)
                                        <span class="text-3xl">Vote</span>
                                    @else
                                        Vote
                                    @endif

                                </h3>
                            </div>
                        </div>
                        <div class="flex items-center text-white md:max-w-xs lg:max-w-none">
                            <div class="flex flex-col flex-auto gap-2">
                                @if(!$user?->has_lido_nft)
                                    <div class="text-xl">
                                        With {{humanNumber(5000000)}} PHUFFY or more you can vote for a cause.
                                        We will refund any transaction fees when you vote.
                                    </div>
                                    <div class="text-xl font-semibold">
                                        Enjoy that phuzzy feeling of doing good.
                                    </div>
                                @else
                                    <h3 class="mt-6 text-4xl md:text-5xl xl:text-6xl">
                                        Bring on the <br/>
                                        phuzzy feelings!
                                    </h3>
                                    <h3 class="text-4xl font-semibold md:text-5xl text-phuffy-600">
                                        You can vote!
                                    </h3>
                                @endif
                            </div>
                        </div>
                        <a href="#current-campaign"
                           class="flex flex-row items-center justify-between w-full h-16 mt-auto text-2xl font-extrabold text-white uppercase hover:text-gray-300 md:text-3xl">
                                <span class="font-display">
                                    Current Causes
                                </span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-12 bg-primary-1000">
        <div class='py-8 text-white bg-phuffy-500/[.25]'>
            <div class="container">
                <div class="md:grid md:grid-cols-5">
                    <div class="col-span-1">
                        <div
                            class="w-1/2 p-8 pt-0 m-auto text-center align-top h-1/2 md:w-full md:h-full text-phuffy-500">
                            @include('svg.megaphone')
                        </div>
                    </div>
                    <div class="col-span-4 text-xl">
                        <p>
                            <b>GET EXCITED: You are here in time for the launch of PHUFFY Coin.</b>
                        </p>
                        <p>To be included in the first round of PHUFFY Coin distribution, note the following dates:</p>
                        <ul class="my-2 ml-8 list-disc list-outside">
                            <li>Stake to the LIDO pool by Jan 1, 2022</li>
                            <li>Register and Validate your delegation by Jan 12, 2022</li>
                            <li>PHUFFY will be distributed before voting opens on Jan 15, 2022.</li>
                        </ul>
                        <p>
                            After Jan 1, new delegators can join anytime and will get PHUFFY whenever LIDO mints a
                            block.
                            <b>Launch participants will just get a little more PHUFFY right away -
                                we've been saving some PHUFFY just for you!</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="current-campaign" class="relative py-16 section3 lg:text-xl bg-phuffy-600">
        <div class="container rounded-sm">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-8">
                <div class="overflow-hidden bg-white rounded-sm md:col-span-5">
                    <div class="py-3">
                        <h2 class="flex flex-col gap-1 p-0 px-6 pt-2 mb-0 text-3xl md:text-5xl text-teal-900 md:flex-row md:items-center">
                            <span>Current Causes</span>
                            <span class="relative flex items-center text-xs top-1 font-body">
                                    <svg class="flex-shrink-0 mr-1.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span class="">
                                        winner will be declared
                                        <time datetime="2020-01-07">April 1, 2022</time>
                                    </span>
                                </span>
                        </h2>
                        <hr class="mt-1 mb-0 border-t-4 border-b-0 border-gray-200 border-dashed"/>
                    </div>
                    <div class="primary-causes">
                        <x-portal.causes :causes="$causes" :votes="$votes"/>
                    </div>
                </div>
                <div class="p-3 border-dashed md:col-span-3 bg-primary-1000 border-primary-1000 text-teal-900">
                    <div class="grid grid-cols-2 gap-3 mt-8 lg:mt-0">
                        <livewire:phuffycoin.eligible-wallet-component />
                        <livewire:phuffycoin.eligible-phuffy-component />
                        <livewire:phuffycoin.minted-phuffy-component />
                        <livewire:phuffycoin.activities-component />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-phuffy2-500 text-teal-900">
        <div class="container">
            <div class="md:grid md:grid-cols-6">
                <div class="col-span-2">
                    <h2 class="text-3xl md:text-5xl">
                        <span>Winning Causes</span>
                    </h2>
                </div>
                <div class="col-span-4">
                    <p>
                        These great causes received donations from LIDO Nation because this
                        community earned PHUFFY and used it to vote for a better tomorrow!
                    </p>
                    <div class="flex flex-row w-full gap-16 mt-6 text-teal-800">
                        <div class="flex flex-col justify-center gap-2">
                            <div
                                class="flex items-center justify-center w-48 h-48 p-4 font-extrabold rounded-full bg-opacity-20 bg-primary-600 text-teal-700">
                                <div class="inline-block w-40 h-40 rounded-full">
                                    @include('svg.lido-giving-hands')
                                </div>
                            </div>
                            <div>
                                <p class="w-48 text-center">
                                    First winner Coming April 2022
                                </p>
                            </div>
                        </div>
                        <div class="block w-full overflow-clip">
                            <div class="flex flex-row gap-8 overflow-clip shrink-0">
                                <div
                                    class="w-48 h-48 p-6 text-3xl font-bold text-center border-8 border-dashed rounded-md border-primary-800">
                                    your favorite cause here!
                                </div>
                                <div
                                    class="w-48 h-48 p-6 text-3xl font-bold text-center border-8 border-dashed rounded-md border-primary-800"></div>
                                <div
                                    class="w-48 h-48 p-6 text-3xl font-bold text-center border-8 border-dashed rounded-md border-primary-800"></div>
                                <div
                                    class="w-48 h-48 p-6 text-3xl font-bold text-center border-8 border-dashed rounded-md border-primary-800"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faqs" class="relative py-12 text-white section-6 lg:text-xl md:py-16">
        <div class="container">
            <div class="p-12 bg-opacity-90 bg-primary-1000">
                <h2 class="z-10 text-3xl uppercase md:text-5xl mb-9">How does it work?</h2>
                <div class="mt-6 lg:mt-0 lg:col-span-2">
                    <dl class="space-y-12">
                        @foreach($faqs as $faq)
                            <div>
                                <dt class="text-2xl font-semibold leading-6 text-white">
                                    {{$faq['question']}}
                                </dt>
                                <dd class="mt-2 text-base text-gray-100">
                                    <x-markdown>{{$faq['answer']}}</x-markdown>
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </section>


    <section class="relative py-16 text-white border-b border-primary-700 bg-primary-1000 section-7 lg:text-xl">
        <div class="container relative">
            <h2 class="z-10 mb-3 text-3xl uppercase md:text-5xl">
                Transparency
            </h2>
            <p class="mb-8">
                Until we deploy smart contracts, here's how you can follow our accounts on the Cardano
                blockchain.
            </p>
            <div class="grid grid-cols-1 gap-6 mb-16 sm:grid-cols-2 lg:grid-cols-3">
                {{--<livewire:phuffycoin.treasurer-wallet-component />
                <livewire:phuffycoin.governor-wallet-component />
                <livewire:phuffycoin.escrow-wallet-component />--}}


            </div>
        </div>
    </section>

</div>
