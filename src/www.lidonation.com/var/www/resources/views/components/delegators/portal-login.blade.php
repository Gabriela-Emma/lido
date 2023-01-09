<section
    class="flex flex-col gap-6 relative" x-transition
    x-show="!user && currPage === 'login'">
    <div class="min-h-full flex flex-col justify-center gap-6">
        <h2 class="text-3xl font-extrabold text-slate-100">
            Sign in to your account
        </h2>

        <form class="space-y-4" action="#" method="POST" @submit.prevent="login">
            <div>
                <label for="loginEmail" class="block text-sm font-medium text-slate-100">
                    Email address
                </label>
                <div class="mt-1">
                    <input
                        id="loginEmail" name="email" type="email" autocomplete="email"
                        class="appearance-none block text-white w-full px-3 py-2 border border-slate-200 placeholder-slate-100 focus:outline-none focus:ring-slate-100 bg-transparent focus:border-slate-100 sm:text-sm">
                </div>
            </div>

            <div>
                <label for="loginPassword" class="block text-sm font-medium text-slate-100">
                    Set a Password
                </label>
                <div class="mt-1">
                    <input
                        id="loginPassword" name="password" type="password" required autocomplete="current-password"
                        class="appearance-none block text-white w-full px-3 py-2 border border-slate-200 placeholder-slate-100 focus:outline-none focus:ring-slate-100 bg-transparent focus:border-slate-100 sm:text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <a href="{{ route('password.forgot') }}"
                       class="font-medium text-teal-100 hover:text-teal-50">
                        Forgot your password?
                    </a>
                </div>
            </div>

            <div class="flex flex-row gap-3 items-center">
                <button
                    type="submit"
                    class="w-full flex justify-center py-1 px-3 border border-transparent rounded-sm shadow-sm text-sm font-medium text-teal-800 bg-accent-400 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-700">
                    Sign in
                </button>
                <span @click="navigate('create-account')" class="text-xs text-yellow-500 block  hover:text-teal-500 font-bold mt-2 hover:cursor-pointer">
                    Create an account
                </span>
            </div>
        </form>

        <div class="flex flex-col items-center" x-show="!!walletName" >
            <div class="relative w-full">
                <div class="absolute w-full inset-0 flex items-center">
                    <div class="w-full border-t border-primary-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span
                          class="px-2 bg-primary700 bg-transparent text-slate-50 font-bold relative -top-0.5">
                        Sign in with your hot wallet
                    </span>
                </div>
            </div>

            <div class="mt-8 text-center inline-flex">
                <x-cardano.wallet-login-btn bg="bg-slate-200" />
            </div>
        </div>

        <div x-show="!walletName" class="inline-block">
            <x-delegators.connect-wallet />
        </div>
    </div>
</section>
