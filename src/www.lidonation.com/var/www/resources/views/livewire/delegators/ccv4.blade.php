<div class="ccv4-campaign relative">
    <div class="absolute left-0 top-0 py-24 w-full h-full flex justify-center items-center z-30"
         x-show="submitting" x-transition>
        <div class="w-52 h-52 p-10 rounded-full">
            <x-theme.spinner square="28"/>
        </div>
    </div>

    <div class="flex flex-col justify-center items-center gap-4" x-show="!stakeAccount">
        <h2>
            Let's get you connected!
        </h2>

        <x-delegators.connect-wallet/>
    </div>


    <div class="mt-4 sm:mt-0 sm:flex-none" x-show="!!stakeAccount">
        <div class="p-4 flex flex-col gap-4 mt-4">
            <div class="border-b border-teal-900 w-full">
                <div class="flex flex-col justify-center items-center gap-4 p-6 border border-white border-dashed"
                     x-show="!ccv4BallotVerified" x-transition>
                    <div class="flex flex-col justify-center items-center text-center">
                        <p class="text-xl xl:text-3xl">
                            Circle V4 election is underway!
                        </p>
                        <p class="text-lg xl:text-xl">
                            We want to incentive participation!
                        </p>
                        <p class="text-xl xl:text-sm">
                            To Learn more about the vote and how to vote or abstain,
                            see: <a target="_blank" href="https://bit.ly/3FFslqF"> https://bit.ly/3FFslqF</a>.
                        </p>
                    </div>
                    <div class="flex flex-col justify-center items-center gap-4 my-2 w-full">
                        <div class="w-full bg-teal-800/90 shadow-sm p-4" x-show="!ballotTx && useHardwareWallet">
                            <div class="w-full">
                                <label for="voteTx" class="block text-sm font-semibold text-slate-200">
                                    Vote Transaction. Paste your tx id from your wallet.
                                    This is the tx received back after you submitted your vote.
                                    It should contain a Ballot <span class="text-green-500 rounded p-1">mint</span> in
                                    it.
                                </label>
                                <div class="flex flex-col rounded-md">
                                    <input type="text" name="voteTx" id="voteTx" x-model="voteTx"
                                           placeholder="10def7aa1da85b2619973eedf1cbff913fb031bd6b83a16f0b"
                                           class="text-slate-800 block w-full rounded-none rounded-t-sm border-teal-300 p-4 focus:border-teal-500 focus:ring-teal-500 sm:text-sm">

                                    <button type="button" @click.prevent="validateCcv4Vote(true)"
                                            class="inline-flex items-center justify-center rounded-none round-b-sm border border-transparent bg-teal-600 px-4 py-2 text-xl xl:text-2xl font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">
                                        <span>Validate</span>
                                    </button>
                                    <p class="text-pink-500 mt-1 text-center" x-show="ballotError" x-transition>
                                        Ballot Error!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="validateCcv4Vote(false)" x-show="!ballotTx && !useHardwareWallet"
                                class="inline-flex items-center justify-center rounded-sm border border-transparent bg-teal-600 px-4 py-2 text-xl xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">
                            Push the button
                        </button>
                        <p class="text-slate-300 text-sm mx-auto px-8">
                            This makes use of CIP 8.
                            You sign a message, we verify the signature against voting data already on the blockchain to
                            find a match!
                            <span class="text-yellow-500">Hardware wallets do not support CIP 8</span>
                        </p>
                        <a @click.prevent="useHardwareWallet = true" href="#">
                            Click here to use a hardware wallet
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-6" x-show="ccv4BallotVerified" x-transition>
                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-16 h-16 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                        </svg>

                        <p class="text-xl lg:text-2xl xl:text-4xl 2xl:text-6xl my-2">
                            Ballot Verified!
                        </p>

                        <a :href="`https://cexplorer.io/tx/${ballotTx}/metadata#data`" target="_blank" x-show="ballotTx"
                           class="inline-flex items-center justify-center text-yellow-500 text-xl xl:text-2xl font-medium text-white focus:outline-none sm:w-auto">
                            Ballot Transaction
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                        </a>
                    </div>

                    <div class="flex flex-col justify-center items-center gap-4" x-show="seeYourLidoRewards"
                         x-transition>
                        <p class="px-28" x-show="!reward">
                            Rewards issued! You can keep earning and stack them, or withdraw them now.
                        </p>
                        <p class="px-28" x-show="!!reward">
                            Rewards already issued!
                        </p>
                        <a href="{{localizeRoute('rewards')}}" type="button"
                           class="inline-flex items-center justify-center rounded-sm border border-transparent bg-teal-600 px-4 py-2 text-xl xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">
                            See your Lido Rewards
                        </a>
                    </div>

                    <div x-show="!seeYourLidoRewards" x-transition>
                        <h2 class="text-center">Claim your reward</h2>
                        <div class="flex gap-4 my-4 w-full">
                            <div class="p-2 flex gap-2 justify-center w-full">
                                <p>
                                    It doesn't matter which one you click on. You will be receiving both!
                                </p>
                                <livewire:rewards.claim-lido-rewards-component :every-epoch="$everyEpoch" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-2" x-show="!seeYourLidoRewards" x-transition>
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <p class="italic font-medium text-slate-100">
                                    LIDO delegators gets a bonus!
                                </p>
                            </div>
                        </div>
                        <div
                            class="-mx-4 mt-4 overflow-hidden ring-1 ring-teal-800 sm:-mx-6 md:mx-0 md:rounded-sm">
                            <table class="min-w-full divide-y divide-teal-800">
                                <thead class="">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-100 sm:pl-6">
                                        Stake
                                    </th>
                                    <th scope="col"
                                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-100 sm:table-cell">
                                        Bonus
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-teal-800">
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                        100 staked
                                    </td>
                                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                        10%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                        1,000 staked
                                    </td>
                                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                        25%
                                    </td>
                                </tr>

                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                        8,000 staked
                                    </td>
                                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                        50%
                                    </td>
                                </tr>

                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-100 sm:pl-6">
                                        20,000 staked
                                    </td>
                                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-50 sm:table-cell">
                                        80%
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
