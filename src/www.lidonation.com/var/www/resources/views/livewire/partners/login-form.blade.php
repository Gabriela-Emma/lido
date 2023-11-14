<form action="#" method="POST" class="space-y-6" x-init="$wire.set('form.walletInfo',walletInfo, false)" wire:submit="login">
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
        <div class="mt-1">
            <input wire:model='form.email' id="email" name="email" type="email" autocomplete="email" required
                class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
        <div>
            @error('form.email')
                <span class="text-red-500 error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="space-y-1">
        <label for="form.password" class="block text-sm font-medium text-slate-700">Password</label>
        <div class="mt-1">
            <input wire:model='form.password' id="password" name="password" type="password" autocomplete="current-password"
                required
                class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
        </div>
        <div>
            @error('form.password')
                <span class="text-red-500 error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input wire:model='form.remember' id="remember-me" name="remember-me" type="checkbox"
                class="w-4 h-4 text-teal-600 rounded border-slate-300 focus:ring-teal-500">
            <label for="remember-me" class="block ml-2 text-sm text-slate-900">Remember me</label>
        </div>
        <div class="text-sm">
            <a href="#" class="font-medium text-teal-600 hover:text-teal-500">Forgot your password?</a>
        </div>
    </div>

    <div>
        <button type="submit"
            class="flex items-center justify-center w-full gap-3 px-4 py-2 text-xl font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm 2xl:text-2xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span>Sign in</span>
        </button>
    </div>
</form>
