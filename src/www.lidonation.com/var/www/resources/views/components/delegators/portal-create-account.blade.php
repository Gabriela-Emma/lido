<section
    class="flex flex-col gap-6 relative" x-transition
    x-show="!user && currPage === 'create-account'">
    <h2 class="text-white">
        Create An Account
    </h2>
    <div>
        <div class="min-h-full flex flex-col justify-center">
            <div class="mt-4 sm:mx-auto w-full">
                <form class="space-y-6" action="#" method="POST" @submit.prevent="createAccount">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-100">
                            What do we call you? (required)
                        </label>
                        <div class="mt-1">
                            <input
                                id="name" name="name" type="text" autocomplete="name" required
                                class="appearance-none block text-white w-full px-3 py-2 border border-slate-200 placeholder-slate-100 focus:outline-none focus:ring-slate-100 bg-transparent focus:border-slate-100 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="newEmail" class="block text-sm font-medium text-slate-100">
                            Email address (<span x-text="stakeAccount.stake_address ? 'optional' : 'required'"></span>)
                        </label>
                        <div class="mt-1">
                            <input
                                id="newEmail" name="email" type="email" autocomplete="email"
                                class="appearance-none block text-white w-full px-3 py-2 border border-slate-200 placeholder-slate-100 focus:outline-none focus:ring-slate-100 bg-transparent focus:border-slate-100 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="newPassword" class="block text-sm font-medium text-slate-100">
                            Set a Password (<span x-text="stakeAccount.stake_address ? 'optional' : 'required'"></span>)
                        </label>
                        <div class="mt-1">
                            <input
                                id="newPassword" name="password" type="password" autocomplete="current-password"
                                class="appearance-none block text-white w-full px-3 py-2 border border-slate-200 placeholder-slate-100 focus:outline-none focus:ring-slate-100 bg-transparent focus:border-slate-100 sm:text-sm">
                        </div>
                    </div>

                    <div class="text-xs text-slate-200 italic">
                        Your stake address will be saved to our database so you login with your wallet going forward.
                    </div>


                    <div class="flex flex-row gap-3 items-center">
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-sm shadow-sm text-sm font-medium text-teal-700 bg-slate-100 hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200">
                            Create Account
                        </button>
                        <span class="text-xs">Already have an account? </span>
                        <span
                            @click="navigate('login')"
                            class="text-sm block text-yellow-500 hover:text-teal-500 font-bold hover:cursor-pointer">
                            Sign in
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
