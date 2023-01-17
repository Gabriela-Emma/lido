@props([
    'withdrawals',
    'availableRewards'
])
<section x-transition x-show="currPage === 'rewards' && (!user && !showRewards)">
    <h2 class="text-center">
        Log in with your wallet to see your rewards.
    </h2>
    @if($availableRewards?->isNotEmpty())
        <div class="mt-8 mx-auto bg-teal-700/80 z-5">
            <x-delegators.portal-has-rewards-cta/>
        </div>
    @endif
</section>
<section x-data="lidoRewards" class="flex flex-col gap-5 relative" x-transition
         x-show="currPage === 'rewards' && (!!user || showRewards)">
    <div class="absolute left-0 top-0 py-24 w-full h-full flex justify-center items-center z-30"
         x-show="working" x-transition>
        <div class="w-52 h-52 p-10 rounded-full">
            <x-theme.spinner square="28"/>
        </div>
    </div>


    <h2 class="font-semibold">
        My LIDO Rewards <span class="text-xs text-teal-500">beta</span>
    </h2>


    <template x-if="withdrawals">
        <div class="absolute left-0 top-0 w-full h-full bg-teal-600 shadow-lg z-10 text-white">
            <div>
                <div class="px-4 py-5 sm:px-6 relative">
                    <h3 class="text-lg font-medium leading-6">
                        Process Rewards
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm">
                        These rewards will be processed to be sent to your address about 1 hr after the start of the
                        next epoch @isset($currEpochNo)(Epoch {{($currEpochNo) + 1 }})@endisset.
                    </p>
                    <div class="mt-2 text-center">
                         <span @click="processWithdrawals"
                               class="inline-flex items-center px-1 py-1 rounded-sm text-sm bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">
                            Process
                        </span>
                    </div>
                    <span class="absolute right-0 top-0 p-2 bg-teal-700 hover:cursor-pointer"
                          @click="withdrawals = false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </span>
                </div>
                <div class="border-t border-teal-200 px-4 py-5 sm:p-0">
                    <div class="flex flex-col items-center gap-8 pt-8" x-show="!withdrawals || withdrawals.length === 0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-16 h-16 text-green-500">
                            <path fill-rule="evenodd"
                                  d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                  clip-rule="evenodd"/>
                        </svg>

                        <p class="mt-1 max-w-2xl text-lg px-8">
                            All rewards have been processed and will be posted to your wallet 1 hr after the start of
                            the next
                            epoch.
                        </p>
                    </div>
                    <dl class="overflow-y-auto">
                        <template x-for="(withdrawal, index) in withdrawals" :key="withdrawal[0]?.asset">
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
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

    <div class="text-white bg-gray-900 bg-opacity-25 rounded-sm pb-2">
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
{{--                    @if($availableRewards?->isNotEmpty())--}}
{{--                        <span @click="withdraw"--}}
{{--                              class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">--}}
{{--                            Withdraw--}}
{{--                        </span>--}}
{{--                    @endif--}}
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
                                <th class="px-6 w-32 py-4 text-sm  truncate flex gap-2">Amount</th>
                                <th class="w-72 px-6 py-4 text-sm">Memo</th>
                                <th class="px-2 py-4 text-sm truncate flex gap-2">Status</th>
                            </tr>
                            </thead>
                            <tbody class="flex flex-col justify-start min-w-full divide-y divide-gray-300 h-52">
                            @if($availableRewards?->isNotEmpty() || !empty($withdrawalsProcessed))
                                @foreach($withdrawalsProcessed->concat($availableRewards) as $reward)
                                    <tr class="flex flex-row text-left" x-transition>
                                        <td class="px-6 py-4 w-32 text-sm truncate flex gap-2 flex items-center">
                                            <span class="font-semibold text-xl 2xl:text-2xl">
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
                                                <span class="relative inline-block rounded-full w-3 h-3">
                                                    {{$reward->asset_details?->metadata?->ticker}}
                                                </span>
                                            @elseif(isset($reward->asset_details?->asset_name))
                                                <span class="relative inline-block rounded-full w-3 h-3">
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

    @if(!empty($withdrawalsProcessed) && $withdrawalsProcessed?->first())
        <div class="flex justify-center">
            <div class="p-4 text-lg font-medium text-green-400">
                Withdrawals processed {{$withdrawalsProcessed?->first()?->processed_at}}
                will be sent to your wallet about 1hr after the start of the next epoch.
            </div>
        </div>
    @endif

    @unlessrole('delegator')
    <div class="my-2">
        <p class="text-xl 2xl:text-2xl text-center text-yellow-500">
            The ability to withdraw coming 12/16.
        </p>
    </div>
    @endunlessrole

    <div class="grid grid-cols-2 gap-2 pt-8">
        <div>
            <h3 class="font-semibold text-gray-300">Phuffy Balance</h3>
            <div class="text-xl font-semibold">
                <span class="text-semibold text-xl xl:text-2xl" x-text="`${numberFormat(phuffyBalance)}`"></span> PHUFFY
            </div>
            <hr class="w-2/3 border-t border-b-0 border-gray-300 border-opacity-50" />
            <h3 class="font-semibold text-gray-300">Donated</h3>
            <div class="text-xl font-semibold">
                <span class="text-semibold text-2xl xl:text-3xl" x-text="'-'"></span> PHUFFY
            </div>
        </div>
        <div>
            <h3 class="font-semibold text-gray-300">
                <span x-show="stakeAccount?.active">Controlled Stake</span>
                <span x-show="!stakeAccount?.active">₳ Balance</span>
            </h3>
            <div class="text-xl font-semibold">
                <span x-text="controlledStake"></span> ₳
            </div>
            <hr class="w-2/3 border-t border-b-0 border-gray-300 border-opacity-50"/>
{{--            <h3 class="w-2 font-semibold text-gray-300 flex flex-row gap-2 flex-nowrap items-center">--}}
{{--                <span>Rewards</span>--}}
{{--                <span--}}
{{--                    @click="withdrawReward()"--}}
{{--                    :class="{--}}
{{--                     'hover:cursor-not-allowed bg-slate-400 hover:bg-slate-400': availableAdaRewards < 5--}}
{{--                    }"--}}
{{--                    class="inline-flex  items-center px-1 py-0.5 rounded text-xs bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">--}}
{{--                    Withdraw--}}
{{--                </span>--}}
{{--            </h3>--}}
{{--            <div class="text-xl font-semibold">--}}
{{--                <span x-text="availableAdaRewards"></span> ₳--}}
{{--            </div>--}}
        </div>
    </div>

</section>
