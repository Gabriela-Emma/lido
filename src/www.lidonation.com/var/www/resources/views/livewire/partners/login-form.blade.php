<form action="#" method="POST" class="space-y-6"  @submit.prevent="partnerLogin">
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
        <div class="mt-1">
            <input id="email" name="email" type="email" autocomplete="email" required
                   class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
    </div>

    <div class="space-y-1">
        <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
        <div class="mt-1">
            <input id="password" name="password" type="password" autocomplete="current-password" required
                   class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox"
                   class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
            <label for="remember-me" class="ml-2 block text-sm text-slate-900">Remember me</label>
        </div>

        <div class="text-sm">
            <a href="#" class="font-medium text-teal-600 hover:text-teal-500">Forgot your password?</a>
        </div>
    </div>

    <div>
        <button type="submit"
                class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span>Sign in</span>
        </button>
    </div>
</form>
