<form action="#" method="POST" class="space-y-6 min-w-[28rem] mx-auto ml-3" @submit.prevent="submitPartnerRegistration">
    <div class="ml-6">
        <label for="name" class="block text-sm font-medium text-slate-600">Name (Required)</label>
        <div class="mt-1">
            <input id="name" name="name" type="text" required autocomplete="name"
                   class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
    </div>
    <div class="ml-6">
        <label for="email" class="block text-sm font-medium text-slate-600">Email address (optional)</label>
        <div class="mt-1">
            <input id="email" name="email" type="email" autocomplete="email"
                   class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
    </div>

    <div class="space-y-1 ml-6">
        <label for="password" class="block text-sm font-medium text-slate-600">Password (optional)</label>
        <div class="mt-1">
            <input id="password" name="password" type="password" autocomplete="current-password"
                   class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
    </div>

    <div  class="flex flex-col overflow-y-auto h-[164px] border border-slate-400 mt-1 p-3 ml-6">
        <p class="text-slate-600 font-medium text-xs mb-3">
            Additional data that will be saved with your registration.
        </p>
        <div class="flex flex-col gap-4">
            <div x-show="!!stakeAddr">
                <b>Stake Address</b>
                <p class="break-all" x-text="stakeAddr"></p>
            </div>

            <div x-show="!!walletAddr">
                <b>Wallet Address</b>
                <p class="break-all" x-text="walletAddr"></p>
            </div>

            <div x-show="assets?.length > 0">
                <b>Asset Id(s)</b>
                <template x-for="asset in assets">
                    <p x-text="asset?.name"></p>
                </template>
            </div>
        </div>
    </div>

    <div class="mt-3 flex flex-col gap-2 ml-6">
        <div class="">
            <button type="submit"
                    class="flex items-center gap-3 w-full justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                <span>Submit Registration</span>
            </button>
        </div>

        <div>
            <button type="button" @click.prevent="registering = false" class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-slate-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-eggplant-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                <span>Sign in</span>
            </button>
        </div>
    </div>
</form>
