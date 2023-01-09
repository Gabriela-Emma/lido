@props([
    'withdrawals',
    'availableRewards'
])
<section class="flex flex-col gap-2 justify-start h-full" x-cloak>
{{--    <div class="absolute left-0 top-0 py-24 w-full h-full flex justify-center items-center z-30"--}}
{{--         x-show="userLoading" x-transition>--}}
{{--        <div class="w-52 h-52 p-10 rounded-full">--}}
{{--            <x-theme.spinner square="28" />--}}
{{--        </div>--}}
{{--    </div>--}}

    <x-delegators.portal-header/>

    <main class="text-white relative">
        <x-delegators.portal-login />

        <x-delegators.portal-create-account />

        <x-delegators.portal-home :withdrawals="$withdrawals" :availableRewards="$availableRewards" />

        @include('components.delegators.portal-rewards')

        <x-delegators.portal-claim-phuffies />

        <section class="flex flex-col gap-6" x-transition x-show="currPage === 'notifications'">
            <h2>Coming Soon</h2>
        </section>

        <section class="flex flex-col gap-6" x-transition x-show="currPage === 'profile'">
            <h2>Coming Soon</h2>
        </section>
    </main>

    <x-delegators.portal-footer />
</section>
