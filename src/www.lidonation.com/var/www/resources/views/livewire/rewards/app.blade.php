<div
    class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white catalyst-proposals-bookmarks-wrapper min-h-[92vh]">
    <div class="container relative h-full">
        <div x-show="working"
             class="left-0 top-0 flex items-start justify-center w-full h-full p-32 absolute bg-teal-600 bg-opacity-90 z-20">
            <div
                class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                <svg
                    class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"
                    viewBox="0 0 24 24"></svg>
            </div>
        </div>

        <div class="grid grid-cols-9 gap-2 relative">
            <div class="col-span-3 xl:col-span-2 p-5 text-right font-semibold text-gray-300">
                <div class="sticky top-16">
                    <div>
                        <ul>
                            <li class="font-medium text-white hover:text-white hover:cursor-pointer">
                                My Rewards
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class=" -mt-px pt-1 mb-8 border border-teal-300 col-span-6 xl:col-span-7">
                <div class="flex flex-row gap-3 justify-between p-5">
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">My Lido Rewards</h2>
                    </div>
                </div>
                <div class="relative">
                    <section class="border-t border-teal-300 p-6" x-transition>
                        <div class="flex flex-col gap-4 items-center">
                            <p>
                                Lido Rewards are tips and prizes you earn around lidonation for completing challenges or
                                contributing to the site, or delegating to the stake pool.
                                They are typically in the form of cardano native tokens (ie: $hosky, $nmkr, $discoin,
                                etc). They can also be NFTs!
                            </p>
                            <p>All your rewards shows up here for accounting and withdrawal!</p>
                            <p>Happy earning!</p>
                        </div>
                    </section>
                    <section class="border-t border-teal-300 p-6 -my-1" x-transition>
                        @auth()
                            <div x-show="!!wallet">
                                <template x-if="withdrawals">
                                    <div
                                        class="absolute left-0 top-0 w-full h-full bg-teal-600 shadow-lg z-10 text-white">
                                        <div>
                                            <div class="px-4 py-5 sm:px-6 relative" x-show="!withdrawalsProcessed">
                                                <h3 class="text-lg font-medium leading-6">
                                                    Process Rewards
                                                </h3>
                                                <p class="mt-1 max-w-2xl text-sm">
                                                    You are about to withdraw pending rewards.
                                                    You will need to send 2 ada, and all pending rewards will be bundled and sent to your
                                                    wallet plus your 2 Ada minus tx fee.
{{--                                                    If you have ada rewards of at least 2 ada, deposit will not be--}}
{{--                                                    required.--}}
                                                </p>
                                                @if($availableRewards?->isNotEmpty())
                                                    <div class="mt-2 text-center">
                                                     <span @click="withdrawalRewards()"
                                                           class="inline-flex items-center px-1 py-1 rounded-sm text-sm bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">
                                                        Withdraw
                                                    </span>
                                                    </div>
                                                @endif

                                                <span
                                                    class="absolute right-0 top-0 p-2 bg-teal-700 hover:cursor-pointer"
                                                    @click="withdrawals = false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke-width="1.5"
                                                         stroke="currentColor" class="w-6 h-6">
                                                      <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </span>
                                            </div>

                                            {{-- Deposit Ada --}}
                                            <div>

                                            </div>

                                            {{-- Verify Deposit --}}
                                            <div>

                                            </div>

                                            {{-- Send Rewards --}}
                                            <div>

                                            </div>

                                            <div class="border-t border-teal-200 px-4 py-5 sm:p-0">
                                                <div class="flex flex-col items-center gap-8 pt-8"
                                                     x-show="withdrawalsProcessed">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                         fill="currentColor"
                                                         class="w-16 h-16 text-green-500">
                                                        <path fill-rule="evenodd"
                                                              d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                              clip-rule="evenodd"/>
                                                    </svg>

                                                    <p class="my-2 max-w-2xl text-lg px-8">
                                                        Your withdrawal will be posted to
                                                        your wallet in about 5 to 10 minutes.
                                                    </p>
                                                </div>
                                                <dl class="overflow-y-auto" x-show="!withdrawalsProcessed">
                                                    <template x-for="(withdrawal, index) in withdrawals"
                                                              :key="withdrawal[0]?.asset">
                                                        <div
                                                            class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                                                            :class="{'bg-teal-700': index % 2 == 0 }">
                                                            <dt class="text-sm font-medium">
                                                                <span class="flex gap-2">
                                                                    <span x-text="getAssetName(withdrawal[0])"></span>
                                                                </span>
                                                            </dt>
                                                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                                                <span class="font-semibold text-xl 2xl:text-2xl"
                                                                      x-text="(
                                                                      withdrawal.reduce((total, asset) => total + asset.amount, 0)
                                                                      /
                                                                      (withdrawal[0]?.asset_details?.divisibility > 0  ? withdrawal[0]?.asset_details?.divisibility : 1))
                                                                      .toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 2})"></span>
                                                                <template x-if="getAssetLogo(withdrawal[0])">
                                                                    <span
                                                                        class="relative inline-flex items-center rounded-full w-4 2xl:w-5 w-4 2xl:h-5 ml-2">
                                                                        <img class="inline-flex"
                                                                             alt="asset logo"
                                                                             :src="getAssetLogo(withdrawal[0])"
                                                                             :alt="getAssetName(withdrawal[0]) + ' logo'"/>
                                                                    </span>
                                                                </template>
                                                            </dd>
                                                        </div>
                                                    </template>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </template>


                                <div class="text-white bg-gray-900 bg-opacity-25 rounded-sm pb-2 relative">
                                    <div class="rounded-tl-sm rounded-tr-md bg-teal-900 shadow-sm">
                                        <div class="flex justify-between items-center px-4">
                                            <h3 class="py-2 font-semibold">
                                                <span>
                                                    Rewards
                                                </span>
                                                <span class="text-xs text-gray-400">
                                                    {{$availableRewards?->count() ?? '-'}}
                                                </span>
                                            </h3>
                                            <div>
                                                @if($availableRewards?->isNotEmpty() || $withdrawals?->isNotEmpty())
                                                    <span @click="withdraw"
                                                          class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">
                                                        Withdraw
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex flex-col">
                                            <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                    <table class="min-w-full overflow-auto divide-y divide-gray-200">
                                                        <thead class="flex flex-col justify-between min-w-full">
                                                        <tr class="flex flex-row text-left" x-transition>
                                                            <th class="px-6 w-32 py-4 text-sm  truncate flex gap-2">
                                                                Amount
                                                            </th>
                                                            <th class="w-72 px-6 py-4 text-sm">Memo</th>
                                                            <th class="px-2 py-4 text-sm truncate flex gap-2">Status
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody
                                                            class="flex flex-col justify-start min-w-full divide-y divide-gray-300 h-72">
                                                        @if($availableRewards?->isNotEmpty() || !empty($withdrawalsProcessed))
                                                            @foreach($withdrawalsProcessed?->concat($availableRewards) ?? [] as $reward)
                                                                <tr class="flex flex-row text-left" x-transition>
                                                                    <td class="px-6 py-4 w-32 text-sm truncate flex gap-2 flex items-center">
                                                                        <span
                                                                            class="font-semibold text-xl 2xl:text-2xl">
                                                                            {{humanNumber($reward->amount / ($reward?->asset_details?->divisibility > 0  ? $reward?->asset_details?->divisibility : 1), 2)}}
                                                                        </span>
                                                                        @if(isset($reward->asset_details?->metadata?->logo))
                                                                            <span
                                                                                class="relative inline-flex items-center rounded-full w-4 2xl:w-5 w-4 2xl:h-5">
                                                                                <img class="inline-flex"
                                                                                     alt="asset logo"
                                                                                     src="data:image/png;base64,{{$reward->asset_details?->metadata?->logo}}">
                                                                            </span>
                                                                        @elseif(isset($reward->asset_details?->metadata?->ticker))
                                                                            <span
                                                                                class="relative inline-block rounded-full w-3 h-3">
                                                                                {{$reward->asset_details?->metadata?->ticker}}
                                                                            </span>
                                                                        @elseif(isset($reward->asset_details?->asset_name))
                                                                            <span
                                                                                class="relative inline-block rounded-full w-3 h-3">
                                                                                {{$reward->asset_details?->asset_name}}
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="w-72 px-6 py-4 text-sm">
                                                                        {{$reward->memo}}
                                                                    </td>
                                                                    <td class="px-2 py-4 text-sm truncate flex gap-2">
                                                                        {{$reward->status}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        @if($availableRewards?->isEmpty() && empty($withdrawalsProcessed))
                                                            <tr class="flex flex-row text-left" x-transition>
                                                                <td class="px-6 py-4 text-sm font-medium">
                                                                    Nothing to see quit yet.
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <div class="flex justify-center" x-data="cardanoWallet"
                             @wallet-loaded.window="walletLoaded($event?.detail)">
                            <div x-show="!walletBalance">
                                <x-cardano.connect-wallet theme="green"/>
                            </div>

                            @guest()
                                <div class="mt-2 flex flex-col gap-6 bg-white/[.92] py-5 px-8" x-show="!!walletBalance"
                                     x-transition>
                                    <div>
                                        <x-cardano.wallet-login-btn
                                            classes='border border-slate-400 hover:bg-slate-100'/>
                                    </div>

                                    <div>
                                        <x-public.divider/>
                                    </div>

                                    <div class="text-slate-800">
                                        <x-cardano.email-login/>
                                    </div>
                                </div>
                            @endguest
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>

    <section class="fixed bottom-4 w-full bg-transparent z-40 pointer-events-none">
        <x-notice/>
    </section>
</div>
