@props([
    'availableRewards'
])
<section class="flex flex-col gap-6" x-transition
         x-show="currPage === 'home'">
    <div
        x-show="delegationTransactionId && !user?.wallet_stake_address"
        class="flex flex-row justify-between items-center text-slate-100 bg-slate-800 bg-opacity-50 py-2 px-3 rounded-sm">
        <div class="pr-8 text-base">
            <h2 class="text-white">
                Create An Account
            </h2>
            <p>
                Thanks for joining LIDO and becoming a co-dreamer!
            </p>
            <p class="text-white">
                Now create an account to get more rewards in addition to staking rewards.
            </p>
        </div>
        <div class="">
            <button
                type="button"
                @click="navigate('create-account')"
                class="inline-flex flex-shrink-0 w-28 items-center justify-center rounded-sm border border-transparent bg-slate-50 px-2 py-1.5 text-sm font-medium text-teal-800 shadow-sm hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-200 focus:ring-offset-2">
                Login
            </button>
            <span @click="navigate('create-account')" class="text-xs text-slate-100 block text-teal-600  hover:text-yellow-500 font-bold mt-2 hover:cursor-pointer">
                Create an account
            </span>
        </div>
    </div>

    <div class="flex flex-row flex-wrap gap-4 text-center">
        <div class="flex flex-col gap-2 bg-primary-400 rounded-2xl p-3 items-center justify-between">
            <div class="flex gap-2 font-bold text-lg xl:text-xl">
                <span x-text="controlledStake"></span>
                <span>₳</span>
            </div>
            <div class="inline-block  w-32 opacity-50 text-base">
                Total Staked
            </div>
        </div>
        <div class="flex flex-col gap-2 bg-accent-700 rounded-2xl p-3 items-center justify-between">
            <div class="flex gap-2 font-bold text-lg xl:text-xl">
                <span x-text="availableAdaRewards"></span>
                <span>₳</span>
            </div>
            {{--                    <button--}}
            {{--                        type="button"--}}
            {{--                        class="p-0.5 w-16 rounded-sm border border-primary-800 hover:bg-white text-xs font-semibold text-teal-800 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">--}}
            {{--                        withdraw--}}
            {{--                    </button>--}}
            <div class="inline-block px-1 opacity-50 text-sm">
                Available Rewards
            </div>
        </div>
        <div class="flex flex-col gap-2 bg-slate-800 text-white rounded-2xl p-3 items-center justify-between">
            <div class="flex gap-2 font-bold text-lg xl:text-xl">
                <span class="text-semibold text-2xl xl:text-3xl" x-text="epochsDelegated">-</span>
            </div>
            <div class="inline-block px-1 opacity-50 text-sm">
                Epochs Delegated
            </div>
        </div>
        <div class="flex flex-col gap-2 bg-white text-slate-800 rounded-2xl p-3 items-center justify-between">
            <div class="flex gap-2 font-bold text-lg xl:text-xl">
                <span class="text-semibold text-2xl xl:text-3xl" x-text="phuffyBalance ? numberFormat(phuffyBalance) : '-'"></span>
            </div>
            <div class="inline-block px-1 opacity-50 text-sm">
                Phuffy Balance
            </div>
        </div>
        <div class="flex flex-col gap-2 bg-primary-400 rounded-2xl p-3 items-center justify-between">
            <div class="flex gap-2 font-bold text-lg xl:text-xl">
                <span class="text-semibold text-2xl xl:text-3xl">-</span>
            </div>
            <div class="inline-block px-1 opacity-50 text-sm">
                Given to Causes
            </div>
        </div>
    </div>


    @if($availableRewards?->isNotEmpty())
        <div class="mt-8 mx-auto bg-teal-700/80 z-5">
            <x-delegators.portal-has-rewards-cta />
        </div>
    @endif
</section>
