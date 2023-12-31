@props([
    'catalystProfile',
    'owner'
])
<div class="z-6" x-data="{
    name: @js($catalystProfile?->name),
    email: @js($catalystProfile?->email),
    bio: @js($catalystProfile?->bio),
    twitter: @js($catalystProfile?->twitter),
    discord: @js($catalystProfile?->discord),
    linkedin: @js($catalystProfile?->linkedin),
    ideascale: @js($catalystProfile?->ideascale),
    code: null,
    step: 1,
    submitted: false,
    goneToIdeascale: false,
    async claimUser(event) {
        const formData = Object.fromEntries(new FormData(event.target));
        const res = await window.axios.post(`/api/catalyst-explorer/people/claim`, formData);
        if (res.status === 200 || res.status === 201) {
            this.code = res.data;
            this.submitted = true;
            this.step = 2;
        }
    }
}">
    <h1 class='flex flex-row flex-wrap items-center items-end gap-2 mb-6 text-2xl font-bold xl:text-3xl 2xl:text-4xl decorate light'>
        Claim Your Account
    </h1>
    <div x-show="step === 1" x-transition>
        <form @submit.prevent="claimUser">
            @csrf
            <div class="flex flex-col gap-4">
                <input type="hidden" name="catalyst_profile_id" value="{{ $owner ?? $catalystProfile->id }}">
                <div class="mt-1 sm:mt-0">
                    <label for="name" class="block text-slate-100 sm:mt-px sm:pt-2">
                        Name
                    </label>
                    <div class="w-full rounded-sm">
                        <input type="text" name="name" id="name" autocomplete="name" x-model="name"
                               class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
                    </div>
                </div>


                <div class="mt-1 sm:mt-0">
                    <label for="email" class="block text-slate-100 sm:mt-px sm:pt-2">
                        Email
                    </label>
                    <div class="w-full rounded-sm">
                        <input type="email" name="email" id="email" autocomplete="email" x-model="email"
                               class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
                    </div>
                </div>

                <div class="mt-1 sm:mt-0">
                    <label for="bio" class="block text-slate-100 sm:mt-px sm:pt-2">
                        Bio
                    </label>
                    <div class="w-full rounded-sm">
                        <textarea type="text" name="bio" id="bio" autocomplete="bio" x-model="bio" rows="4"
                                  class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
                        </textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 xl:gap-8">
                    <div class="mt-1 sm:mt-0">
                        <label for="ideascale" class="block text-slate-100 sm:mt-px sm:pt-2">
                            Ideascale <span class="opacity-50 text-slate-200">(Profile link)</span>
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="ideascale" id="ideascale" autocomplete="ideascale"
                                   x-model="ideascale"
                                   class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-1 sm:mt-0">
                        <label for="twitter" class="block text-slate-100 sm:mt-px sm:pt-2">
                            Twitter <span class="opacity-50 text-slate-200">(@handle)</span>
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="twitter" id="twitter" autocomplete="twitter" x-model="twitter"
                                   class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
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
                                   class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-1 sm:mt-0">
                        <label for="linkedin" class="block text-slate-100 sm:mt-px sm:pt-2">
                            LinkedIn <span class="opacity-50 text-slate-200">(Profile link)</span>
                        </label>
                        <div class="w-full rounded-sm">
                            <input type="text" name="linkedin" id="linkedin" autocomplete="linkedin" x-model="linkedin"
                                   class="flex-1 block w-full min-w-0 bg-transparent border-2 rounded-none rounded-r-md border-slate-100 focus:border-slate-800 focus:ring-slate-800 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-2">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-3 text-base font-medium text-teal-600 bg-white border border-transparent rounded-sm shadow-xs xl:text-xl hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
                        Submit
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div x-show="step === 2" x-transition class="mb-8">
        <h2 class="flex flex-col items-center justify-center w-full gap-2 text-2xl xl:text-4xl 2xl:text-6xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
            <span>
                Lets get you verified!
            </span>
        </h2>

        <div class="flex flex-col items-center gap-1 my-8 font-semibold text-slate-800">
            <div class="text-sm font-normal">
                Verification Code
            </div>
            <bold class="xl:text-4xl">CODE$: <span class="text-green-600" x-text="code"></span></bold>
        </div>

        <div class="text-center">
            <p x-show="goneToIdeascale">
                Great! You may close this page<br />
                after you've sent us the code on ideascale.
            </p>
            <p x-show="goneToIdeascale">
                You will receive a confirmation once your account is validated
            </p>

            <p x-show="!goneToIdeascale">
                To verify your ownership of this profile, <br />
                please send a personal message to
                <a target="_blank" class="inline-flex items-center gap-1" href="https://cardano.ideascale.com/c/profile/178404/">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-teal-light-600">
                        <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-teal-light-400">
                        Lido Nation
                    </span>
                </a><br />
                on ideascale and include the code above.
            </p>
        </div>

        <div class="flex justify-center mt-6">
            <a href="https://cardano.ideascale.com/c/profile/178404/" target="_blank" type="button" @click="goneToIdeascale = true"
                    class="inline-flex items-center px-4 py-3 text-base font-medium text-teal-600 bg-white border border-transparent rounded-sm shadow-xs xl:text-xl hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
                Go to Ideascale
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 ml-2 ">
                    <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>

    <div class="flex flex-row items-center justify-center gap-1 text-3xl text-white">
        <div :class="{'text-6xl opacity-100': step === 1, 'opacity-50': step !== 1}">&bull;</div>
        <div :class="{'text-6xl opacity-100': step === 2, 'opacity-50': step !== 2}">&bull;</div>
    </div>
</div>
