<div id="delegation-learning-modeule"
class="relative flex flex-col w-full h-full bg-cover bg-primary-1000"
x-data="delegationLearningModule" x-cloak>
    <div class="absolute w-full h-full overflow-hidden">
        <header class="absolute top-0 w-full h-20">
            <div class="flex justify-between">
                <div></div>
                <div @closemodule.window="step = 0">
                    <div class="px-6 py-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 hover:text-phuffy-500 hover:cursor-pointer"
                        fill="none"
                        @click="$dispatch('closemodule')"
                        viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </header>
        <!-- Step 0 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]" x-show='step===0'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            <h2 class="text-center text-gray-200">
                We're excited you're considering delegating with us!
            </h2>
            <div class="text-center">
                <h2 class="px-5 mb-6 text-4xl 2xl:text-5xl md:px-10">
                    Learn about Delegation on Cardano
                </h2>
                <div class="flex flex-row justify-center gap-6">
                    <button  @click="step = 6" type="button"
                    class="inline-flex items-center px-6 py-3 text-2xl font-medium text-gray-300 border border-gray-300 rounded-sm hover:text-white hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Skip Lesson
                    </button>
                    <button type="button" @click="step++"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Start Lesson
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 1 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]" x-show='step===1'
        {{-- x-transition:enter="transition ease-out duration-100 translate-x-[100%]"
        x-transition:enter-start="transform opacity-0 translate-x-[50%]"
        x-transition:enter-end="transform opacity-100 translate-x-[0]"
        x-transition:leave="transition ease-in duration-75 translate-x-[-50%]"
        x-transition:leave-start="transform opacity-100 translate-x-[-75%]"
        x-transition:leave-end="transform opacity-0 translate-x-[-100%]" --}}
        x-transition:leave.duration.200ms
        x-transition:enter.duration.300ms>
            {{-- <h2 class="text-center text-gray-200">
                Introduction
            </h2> --}}
            <div class="flex flex-col justify-start h-full gap-1">
                <h2 class="mb-0 text-3xl text-gray-300">
                    Rewards for Everyone
                </h2>

                <div>
                    <p>
                        Cardano rewards participants, decentralizes power and secures transactions using a network of computer nodes, called Staking Pools.
                    </p>
                    <p>
                        Unlike First Generation blockchain networks that use a “proof-of-work” protocol, which require massive computers and vast resources,  proof-of-stake networks use the native currency to secure the network efficiently.
                    </p>
                </div>

                <div class="flex flex-row justify-end gap-6 mt-auto">
                    <button type="button" @click="step++"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Next
                    </button>
                </div>
            </div>
        </div>


        <!-- Step 2 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]" x-show='step===2'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            {{-- <h2 class="text-center text-gray-200">
                Introduction
            </h2> --}}
            <div class="flex flex-col justify-start h-full gap-1">
                <h2 class="mb-0 text-3xl text-gray-300">
                    The Network
                </h2>

                <div>
                    <p>
                        The Cardano “Network” is just that: a network of connected computer nodes. Each node is maintained by a stake pool operator.
                    </p>
                    <p>
                        When there are transactions on the network, a node is randomly selected to validate them on the blockchain.
                        Sharing responsibilities removes the need to trust a central authority.
                    </p>
                </div>

                <div class="flex flex-row justify-end gap-6 mt-auto">
                    <button type="button" @click="step--"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Back
                    </button>
                    <button type="button" @click="step++"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Next
                    </button>
                </div>
            </div>
        </div>


        <!-- Step 3 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]"
            x-show='step===3'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            {{-- <h2 class="text-center text-gray-200">
                Introduction
            </h2> --}}
            <div class="flex flex-col justify-start h-full gap-1">
                <h2 class="mb-0 text-3xl text-gray-300">
                    The Pools
                </h2>
                <div>
                    <p>
                        Pool operators are rewarded for the work they do to run the network.
                    </p>
                    <p>
                        At the end of each “Epoch” (5 days), pools that were selected to mint a block receive ADA as a reward.
                    </p>
                </div>

                <div class="flex flex-row justify-end gap-6 mt-auto">
                    <button type="button" @click="step--"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Back
                    </button>
                    <button type="button" @click="step++"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Next
                    </button>
                </div>
            </div>
        </div>


        <!-- Step 4 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]"
            x-show='step===4'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            {{-- <h2 class="text-center text-gray-200">
                Introduction
            </h2> --}}
            <div class="flex flex-col justify-start h-full gap-1">
                <h2 class="mb-0 text-3xl text-gray-300">
                    Staking
                </h2>
                <div>
                    <p>
                        Not everyone wants to participate by running and maintaining a computer server.
                    </p>
                    <p>
                        This is where staking comes in: you can delegate your ADA to a pool.
                        This is where staking comes in: you can delegate your ADA to a pool. Then, when that pool gets rewarded, you get paid too.
                    </p>
                </div>

                <div class="flex flex-row justify-end gap-6 mt-auto">
                    <button type="button" @click="step--"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Back
                    </button>
                    <button type="button" @click="step++"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Next
                    </button>
                </div>
            </div>
        </div>


        <!-- Step 5 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]"
            x-show='step===5'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            {{-- <h2 class="text-center text-gray-200">
                Introduction
            </h2> --}}
            <div class="flex flex-col justify-start h-full gap-1">
                <h2 class="mb-0 text-3xl text-gray-300">
                    Staking is no-risk and all reward.
                </h2>
                <div>
                    <p>
                        You can spend, trade, or use your ADA whenever you want to. While your ADA is staked, you are eligible to earn rewards.
                    </p>
                    <p>
                        Staked Cardano earns about 5.5% annually in rewards.
                    </p>
                </div>

                <div class="flex flex-row justify-end gap-6 mt-auto">
                    <button type="button" @click="step--"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Back
                    </button>
                    <button type="button" @click="step++"
                        class="inline-flex items-center px-6 py-3 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Finish
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 6 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]"
        x-show='step===6'
        x-transition:leave.duration.200ms
        x-transition:enter.duration.300ms>
            <h2 class="text-center text-gray-200">
                You're ready to delegate your stake!
            </h2>
            <div class="text-center">
                <h2 class="px-5 mb-6 text-3xl 2xl:text-4xl md:px-10">
                    Congratulations on taking a big step towards a future that works for you too!
                </h2>
                <div class="flex flex-row justify-center gap-6">
                    <button type="button" @click="step++"
                    class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Stake to LIDO Nation Pool
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 7 -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]" x-show='step===7'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            <h2 class="text-center text-gray-200">
                Wallet Selection
            </h2>
            <div class="text-center">
                <h2 class="px-5 mb-6 text-4xl 2xl:text-5xl md:px-20">
                    What Wallet are you Using?
                </h2>
                <div class="flex flex-row justify-center gap-4">
                    {{--Daedalus--}}
                    <button type="button" @click="walletName='daedalus'; step = 8"
                            class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Daedalus
                    </button>

                    {{-- Nami --}}
                    <button x-show="walletService?.supports('nami')" @click="delegate('nami')"
                            class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        <img x-show="walletService?.supports('nami')" class="w-6 h-6 mr-2" :alt="walletName + '  wallet icon'" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0ODYuMTcgNDk5Ljg2Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzM0OWVhMzt9PC9zdHlsZT48L2RlZnM+PGcgaWQ9IkxheWVyXzIiIGRhdGEtbmFtZT0iTGF5ZXIgMiI+PGcgaWQ9IkxheWVyXzEtMiIgZGF0YS1uYW1lPSJMYXllciAxIj48cGF0aCBpZD0icGF0aDE2IiBjbGFzcz0iY2xzLTEiIGQ9Ik03My44Nyw1Mi4xNSw2Mi4xMSw0MC4wN0EyMy45MywyMy45MywwLDAsMSw0MS45LDYxLjg3TDU0LDczLjA5LDQ4Ni4xNyw0NzZaTTEwMi40LDE2OC45M1Y0MDkuNDdhMjMuNzYsMjMuNzYsMCwwLDEsMzIuMTMtMi4xNFYyNDUuOTRMMzk1LDQ5OS44Nmg0NC44N1ptMzAzLjM2LTU1LjU4YTIzLjg0LDIzLjg0LDAsMCwxLTE2LjY0LTYuNjh2MTYyLjhMMTMzLjQ2LDE1LjU3SDg0TDQyMS4yOCwzNDUuNzlWMTA3LjZBMjMuNzIsMjMuNzIsMCwwLDEsNDA1Ljc2LDExMy4zNVoiLz48cGF0aCBpZD0icGF0aDE4IiBjbGFzcz0iY2xzLTEiIGQ9Ik0zOC4yNywwQTM4LjI1LDM4LjI1LDAsMSwwLDc2LjQ5LDM4LjI3djBBMzguMjgsMzguMjgsMCwwLDAsMzguMjcsMFpNNDEuOSw2MS44YTIyLDIyLDAsMCwxLTMuNjMuMjhBMjMuOTQsMjMuOTQsMCwxLDEsNjIuMTgsMzguMTNWNDBBMjMuOTQsMjMuOTQsMCwwLDEsNDEuOSw2MS44WiIvPjxwYXRoIGlkPSJwYXRoMjAiIGNsYXNzPSJjbHMtMSIgZD0iTTQwNS43Niw1MS4yYTM4LjI0LDM4LjI0LDAsMCwwLDAsNzYuNDYsMzcuNTcsMzcuNTcsMCwwLDAsMTUuNTItMy4zQTM4LjIyLDM4LjIyLDAsMCwwLDQwNS43Niw1MS4yWm0xNS41Miw1Ni40YTIzLjkxLDIzLjkxLDAsMSwxLDguMzktMTguMThBMjMuOTEsMjMuOTEsMCwwLDEsNDIxLjI4LDEwNy42WiIvPjxwYXRoIGlkPSJwYXRoMjIiIGNsYXNzPSJjbHMtMSIgZD0iTTEzNC41OCwzOTAuODFBMzguMjUsMzguMjUsMCwxLDAsMTU3LjkyLDQyNmEzOC4yNCwzOC4yNCwwLDAsMC0yMy4zNC0zNS4yMlptLTE1LDU5LjEzQTIzLjkxLDIzLjkxLDAsMSwxLDE0My41NCw0MjZhMjMuOSwyMy45LDAsMCwxLTIzLjk0LDIzLjkxWiIvPjwvZz48L2c+PC9zdmc+" />
                        <span>Nami</span>
                    </button>
                    <a x-show="!walletService?.supports('nami')" href="//namiwallet.io" type="button" target="_blank"
                       class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        <span class="mr-2">Install Nami</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    {{--Typhon--}}
                    <button x-show="walletService?.supports('typhon')" @click="delegate('typhon')"
                    class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        <img x-show="walletService?.supports('typhon')" class="w-6 h-6 mr-2" :alt="walletName + '  wallet icon'" src="https://typhonwallet.io/assets/typhon.svg" />
                        <span>Typhon</span>
                    </button>
                    <a x-show="!walletService?.supports('typhon')" href="//typhonwallet.io" type="button" target="_blank"
                       class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        <span class="mr-2">Install Typhon</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>



                    {{--Yoroi--}}
                    <button type="button" @click="walletName='yoroi'; step = 9"
                    class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Yoroi
                    </button>
                    {{-- <button type="button" @click="wallet='namie'; step = 10"
                    class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                        Nami
                    </button> --}}
                </div>
                <ul class="mt-8 mx-auto max-w-md" x-show="errors">
                    <template x-for="error in errors">
                        <li class="rounded-sm bg-red200 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800" x-text="error"></h3>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <!-- Step 8 Daedalus -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]" x-show='step===8'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            <h2 class="text-center text-gray-200">
                <span class="capitalize" x-text="walletName"></span> Wallet Delegation
            </h2>
            <div class="flex flex-row gap-6 overflow-x-scroll flex-nowrap">
                <!-- 1 -->
                <div class="flex flex-row gap-y-4 justify-start p-2 rounded-sm shadow-sm min-w-[85%] bg-teal-600/70">
                    <img class="w-56 mx-auto rounded-sm h-60"
                    src="/img/daedalus-delegation-tab-screenshot.jpg"
                    alt="">
                    <div class="p-3">
                        <div class="mb-2 text-xl font-semibold 2xl:text-2xl">
                            Go to the delegation tab on the left
                        </div>
                        <p class="text-base italic text-gray-200">
                            If you only recently setup Daedalus or hasn't started it for a while,
                            the Delegation tab may not load while your wallet is syncing up with the blockchain.
                        </p>
                    </div>
                </div>

                <!-- 2 -->
                <div class="flex flex-row gap-y-4 justify-start p-2 min-w-[85%] rounded-sm shadow-sm bg-teal-600/70">
                    <img class="w-56 mx-auto rounded-sm h-60"
                    src="/img/daedalus-stakepools-tab-screenshot.png"
                    alt="">
                    <div class="p-3">
                        <div class="mb-2 text-xl font-semibold 2xl:text-2xl">
                            Click on the middle 'Stake Pools' tab on the top
                        </div>
                        <p class="text-base italic text-gray-200">
                            You must have atleast 3 ADA to delegate.
                        </p>
                    </div>
                </div>

                <!-- 3 -->
                <div class="flex flex-row gap-y-4 justify-start p-2 min-w-[85%] rounded-sm shadow-sm bg-teal-600/70">
                    <img class="w-56 mx-auto rounded-sm h-60"
                    src="/img/daedalus-delegate-to-lido-screenshot.png"
                    alt="">
                    <div class="p-3">
                        <div class="mb-2 text-xl font-semibold 2xl:text-2xl">
                            Search for <b>LIDO</b> in the search field
                        </div>

                        <div class="mb-2 text-xl font-semibold 2xl:text-2xl">
                            Click on 'LIDO', then the 'Delegate to this pool button'
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-between mt-auto text-4xl font-semibold text-gray-200">
                <div class='hover:cursor-pointer hover:text-white'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                </div>
                <div class='hover:cursor-pointer hover:text-white'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Step 9 Yoroi -->
        <div class="flex flex-col h-full w-full gap-5 p-6 bg-teal-600/[0.82]" x-show='step===9'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            <h2 class="text-center text-gray-200">
                <span class="capitalize" x-text="walletName"></span> Wallet Delegation
            </h2>
            <div class="flex flex-row gap-6 overflow-x-scroll flex-nowrap">
                <!-- 1 -->
                <div class="flex flex-row gap-y-4 justify-start p-2 rounded-sm shadow-sm min-w-[85%] bg-teal-600/70">
                    <img class="w-56 mx-auto rounded-sm h-60"
                    src="/img/yoroi-delegation-tab-screenshot-1.jpg"
                    alt="">
                    <div class="p-3">
                        <h2 class="mb-2 text-3xl 2xl:text-4xl">
                            Go to the delegate tab
                        </h2>
                        <p class="text-base italic text-gray-200">
                            On the browser extension, the tab is "Delegation List."
                            It's just "Delegate" on the mobile apps. The blue "Go to Staking Center" button,
                            if you have it, will also take you were you need to be.
                        </p>
                    </div>
                </div>

                <!-- 2 -->
                <div class="flex flex-row gap-y-4 justify-start p-2 min-w-[85%] rounded-sm shadow-sm bg-teal-600/70">
                    <img class="w-56 mx-auto rounded-sm h-60"
                    src="/img/yoroi-delegation-tab-screenshot-2.jpg"
                    alt="">
                    <div class="p-3">
                        <h2 class="mb-2 text-3xl 2xl:text-4xl">
                            Search for <span class="font-bold">lido</span>
                        </h2>
                        <p class="text-base italic text-gray-200">
                            Scroll down and click the "Delegate" button under "[LIDO] Lido Nation."
                        </p>
                    </div>
                </div>

                <!-- 3 -->
                <div class="flex flex-row gap-y-4 justify-start p-2 min-w-[85%] rounded-sm shadow-sm bg-teal-600/70">
                    <img class="w-56 mx-auto rounded-sm h-60"
                    src="/img/yoroi-delegation-tab-screenshot-3.jpg"
                    alt="">
                    <div class="p-3">
                        <h2 class="mb-2 text-3xl 2xl:text-4xl">
                            Enter Password and Delegate
                        </h2>
                        <p class="text-base italic text-gray-200">
                            Enter spending password, then press the "Delegate" button to confirm. If delegating for the first time,
                            the 2ADA will be locked up, and 0.174257 ADA will be spent cover the transaction fee.
                            If you ever undelegate, you will get your 2 ADA back.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-between text-4xl font-semibold text-gray-200">
                <div class='hover:cursor-pointer hover:text-white'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                </div>
                <div class='hover:cursor-pointer hover:text-white'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Step 10 Delegated -->
        <div class="flex flex-col h-full w-full gap-4 p-6 bg-teal-600/[0.82]" x-show='step===10'
            x-transition:leave.duration.200ms
            x-transition:enter.duration.300ms>
            <h2 class="text-center text-gray-200">
                <span class="capitalize" x-text="walletName"></span> Wallet Delegation Complete!
            </h2>

            <div class="flex flex-col justify-between text-center">
                <h2 class="px-5 mb-6 text-4xl xl:text-5xl 2xl:text-7xl md:px-10 text-center">
                    Welcome to <br />LIDO Nation!
                </h2>
                <p>
                    It will take a few minutes for delegation to make its way around the world.
                    Then 10 days before you see rewards from LIDO!
                </p>
            </div>
            <div class="flex flex-row justify-center gap-6 my-6 mb-8">
                <button type="button" @click="$dispatch('closemodule')"
                        class="inline-flex items-center px-4 py-2 text-2xl font-medium text-white border border-white rounded-sm hover:bg-phuffy2-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-phuffy2-500">
                    Close Widget
                </button>
            </div>
        </div>
    </div>

    <style type="text/css">
        #delegation-learning-modeule{
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 800 800'%3E%3Cg fill-opacity='0.98'%3E%3Ccircle fill='%23002557' cx='400' cy='400' r='600'/%3E%3Ccircle fill='%23133771' cx='400' cy='400' r='500'/%3E%3Ccircle fill='%23254b8d' cx='400' cy='400' r='400'/%3E%3Ccircle fill='%23355fa9' cx='400' cy='400' r='300'/%3E%3Ccircle fill='%234674c6' cx='400' cy='400' r='200'/%3E%3Ccircle fill='%23578AE4' cx='400' cy='400' r='100'/%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</div>
