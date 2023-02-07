@props([
    'user'
])
<div class="z-6" x-data="{
    name: @js($user?->name),
    email: @js($user?->email),
    bio: @js($user?->bio),
    twitter: @js($user?->twitter),
    discord: @js($user?->discord),
    linkedin: @js($user?->linkedin),
    ideascale: @js($user?->ideascale),
    step: 1,
    claimUser($event) {
        console.log($event);
    }
}">
    <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-2xl xl:text-3xl font-bold 2xl:text-4xl decorate light items-center'>
        Claim Your Account - <span class="text-sm text-slate-800">coming soon</span>
    </h1>
    <div>
        <form @submit.prevent="claimUser">
            <div class="flex flex-col gap-4">
                <div class="mt-1 sm:mt-0">
                    <label for="name" class="block text-slate-100 sm:mt-px sm:pt-2">
                        Name
                    </label>
                    <div class="w-full rounded-sm">
                        <input type="text" name="name" id="name" autocomplete="name" x-model="name"
                               class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                    </div>
                </div>


                <div class="mt-1 sm:mt-0">
                    <label for="name" class="block text-slate-100 sm:mt-px sm:pt-2">
                        Email
                    </label>
                    <div class="w-full rounded-sm">
                        <input type="text" name="email" id="email" autocomplete="email" x-model="email"
                               class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                    </div>
                </div>

                <div class="mt-1 sm:mt-0">
                    <label for="bio" class="block text-slate-100 sm:mt-px sm:pt-2">
                        Bio
                    </label>
                    <div class="w-full rounded-sm">
                        <textarea type="text" name="bio" id="bio" autocomplete="bio" x-model="bio" rows="4"
                                  class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                        </textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 xl:gap-8">
                    <div class="mt-1 sm:mt-0">
                        <label for="ideascale" class="block text-slate-100 sm:mt-px sm:pt-2">
                            Ideascale
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="ideascale" id="ideascale" autocomplete="ideascale"
                                   x-model="ideascale"
                                   class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                        </div>
                    </div>

                    <div class="mt-1 sm:mt-0">
                        <label for="twitter" class="block text-slate-100 sm:mt-px sm:pt-2">
                            Twitter
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="twitter" id="twitter" autocomplete="twitter" x-model="twitter"
                                   class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 xl:gap-8">
                    <div class="mt-1 sm:mt-0">
                        <label for="discord" class="block text-slate-100 sm:mt-px sm:pt-2">
                            Discord
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="discord" id="discord" autocomplete="discord" x-model="discord"
                                   class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                        </div>
                    </div>

                    <div class="mt-1 sm:mt-0">
                        <label for="linkedin" class="block text-slate-100 sm:mt-px sm:pt-2">
                            LinkedIn
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="linkedin" id="linkedin" autocomplete="linkedin" x-model="linkedin"
                                   class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-2 border-slate-100 focus:border-slate-800 bg-transparent focus:ring-slate-800 sm:text-sm w-full">
                        </div>
                    </div>
                </div>

                <div class="mt-2 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center rounded-sm border border-transparent bg-white py-3 px-4 text-base xl:text-xl font-medium text-teal-600 shadow-xs hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 pr-2">
                        Submit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
        <div class="flex flex-row items-center justify-center gap-1 text-3xl text-white">
            <div :class="{'text-6xl opacity-100': step === 1, 'opacity-50': step !== 1}">&bull;</div>
            <div :class="{'text-6xl opacity-100': step === 2, 'opacity-50': step !== 2}">&bull;</div>
        </div>
    </div>
</div>
