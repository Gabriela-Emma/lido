<header class="text-white" x-transition x-show="!['create-account', 'login'].includes(currPage)">
    <span class="inline-block text-lg">Welcome</span>
    <span
        x-show="user" @click="logout()"
        class="inline-block text-slate-800 text-xs ml-2 bg-slate-200 py-0.5 px-1 rounded-sm hover:bg-slate-400 hover:cursor-pointer">
        Logout
    </span>
    <div>
        <span
            x-show="!user"
            class="inline-block break-all select-all text-slate-200 text-sm"
            x-text="stakeAccount?.stake_address"></span>
        <span
            x-show="user"
            class="inline-block break-all select-all text-slate-200 text-lg"
        x-text="user?.name || user?.wallet_stake_address"></span>
    </div>

    <div x-show="isDelegatedToLido && !user"
         class="mt-4 flex flex-row gap-2 items-center">
         <span
              @click="navigate('login')"
             class="inline-block text-teal-800 text-lg 2xl:text-xl bg-accent-400 py-1 px-2 rounded-sm shadow hover:bg-accent-700 hover:cursor-pointer">
            Login
        </span>
        <span
            @click="navigate('create-account')"
            class="text-teal-600 hover:cursor-pointer font-semibold text-sm hover:text-yellow-700">
            Create an Account
        </span>
    </div>

    <div class="my-3">
        <hr class="border-primary-800" />
    </div>
</header>
