<div>
    <div class="flex flex-col items-center justify-center" x-show="!walletLoaded">
        <h2>
            Let's get you connected!
        </h2>
        <x-delegators.connect-wallet />
    </div>

    <div x-show="walletLoaded" x-transition class="flex flex-col items-center justify-center gap-4">
        <div class="text-center" x-show="(!rewards || rewards.length === 0) && eligible === null">
            <button
                x-on:click="checkEligibility()"
                type="button"
                class="bg-white px-4 py-2.5 w-full md:w-80 rounded-tl-sm rounded-tr-sm opacity-100">
                <span class="text-xl tracking-wide md:text-2xl text-slate-700">Check eligibility</span>
            </button>
        </div>
        <div class="flex flex-col gap-8 text-center" x-show="(!rewards || rewards.length === 0 || withdrawalCardanoScanLinks.length === 0) && eligible === 'false'">
            <h2>
                Sorry, doesn't look like this wallet voted. Try another wallet?
            </h2>
            <div>
                <button type="button"
                        x-on:click="switchWallet()"
                        class="border border-green-500 bg-transparent px-2 py-1.5 text-xl font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Switch Wallet
                </button>
            </div>
        </div>
        <div class="text-center" x-show="eligible === 'true'">
            <h2 class="text-center" x-show="(!rewards || rewards.length === 0) && withdrawalCardanoScanLinks.length === 0">
                Thanks for voting! Claim your rewards.
            </h2>
            <h2 class="text-center" x-show="rewards.length > 0 && withdrawalCardanoScanLinks.length === 0">
                Thanks for voting! Rewards have been issued to your account.
            </h2>
            <h2 class="text-center" x-show="(!rewards || rewards.length === 0) && withdrawalCardanoScanLinks.length > 0">
                Thanks for voting!
            </h2>
            <h2 class="text-center" x-show="rewards.length > 0 && withdrawalCardanoScanLinks.length > 0">
                Thanks for voting! See your pending rewards and already withdrawn transaction details.
            </h2>
            <div class="flex flex-col w-full gap-8 items-centre">
                <div class="flex flex-row justify-center gap-4 mt-8"
                    x-show="(rewards || rewards.length > 0) || withdrawalCardanoScanLinks.length > 0">
                    <div class="inline-flex gap-2 items-center rounded-sm border border-teal-100 bg-transparent px-2.5 py-1.5 text-md font-semibold text-teal-100">
                        <div>$HOSKY</div>
                        <div>69M</div>
                    </div>
                    <div class="inline-flex gap-2 items-center rounded-sm border border-teal-100 bg-transparent px-2.5 py-1.5 text-md font-semibold text-teal-100">
                        <div>$DISCOIN</div>
                        <div>577</div>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center w-auto gap-8">
                    <button type="button"
                            x-on:click="claimReward()"
                            x-show="(!rewards || rewards.length === 0) && withdrawalCardanoScanLinks.length === 0"
                            class="inline-flex items-center gap-2 w-fixed rounded-sm border border-green-500 bg-transparent px-2 py-1.5 text-xl font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <span>Claim Rewards</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </button>
                    <a class="inline-flex items-center gap-2 w-fixed rounded-sm border border-green-500 bg-transparent px-2 py-1.5 text-xl font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        href="{{localizeRoute('rewards.index')}}"
                        x-show="rewards.length > 0">
                        <span>See & Withdraw my LiDO Rewards</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                    <a class="inline-flex items-center gap-2 w-fixed rounded-sm border border-green-500 bg-transparent px-2 py-1.5 text-xl font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        :href="withdrawalCardanoScanLinks[0]"
                        target="_blank"
                        x-show="withdrawalCardanoScanLinks.length > 0">
                        <span>See Transaction Details (cardanoscan.io)</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
