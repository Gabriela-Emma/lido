<div style="display:none" id="slteModal">
    <div x-data="{ 'showModal': true }" @keydown.escape="showModal = false">
        <div
            class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
            x-show="showModal"
        >
           <div class="bg-gradient-to-b from-teal-900 to-teal-500 py-12 w-auto flex flex-col rounded-sm relative overflow-clip">
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col items-center">
                            <h1 class="font-medium text-gray-300 w-auto brightness-100 ">
                                Bookmark  <span class="text-white">  Ledger Live Intergration </span>
                            </h1>
                            <p class="mt-4 mb-4 text-md text-gray-300 w-3/5">
                                Jifunze kupata mapato kwa njia hii mupya. Weza kujifunza ukijinufaisha kwa kuweza kupata malipo.
                            </p>
                        </div>
                        <button type="button" class="z-50 cursor-pointer hover:text-white" @click="showModal = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                     
                    <div class="max-w-lg mx-auto rounded-sm shadow-lg overflow-hidden lg:max-w-none lg:flex">  
                        <div class="flex-1 bg-teal-500">
                            <div class="flex justify-between w-full">
                                <div class="flex items-center p-4 w-auto text-white" >
                                    Unaweza kujisajili leo hii kwa njia rahisi mno.
                                </div>
                                <div class="bg-teal-600 ml-auto">
                                    <div class="bg-slate-100 login-form-wrapper">
                                        <form>
                                            <div class=" bg-white shadow-sm  rounded  p-6 w-96">

                                                <div>
                                                    <div class=" flex justify-start mb-2">
                                                        <h1 class="text-2xl lg:text-3xl 2xl:text-5xl 3xl:text-6xl font-semibold text-slate-700"> Login </h1>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                                                        <div class="mt-1 ">
                                                            <input v-model="form.email" id="email" name="email" type="email" autocomplete="email"
                                                                required
                                                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3  py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                                            <div v-if="form.errors.email" v-text="form.errors.email"
                                                                class="text-red-500 text-xs mt-1"></div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="email" class="block text-sm font-medium text-slate-700">Password</label>
                                                        <div class="mt-1">
                                                            <input v-model="form.password" id="password" name="password" type="password"
                                                                autocomplete="password" required
                                                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3  py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                                            <div v-if="form.errors.password" v-text="form.errors.password"
                                                                class="text-red-500 text-xs mt-1"></div>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center justify-between mt-4 mb-2">
                                                        <div class="flex items-center">
                                                            <input v-model="form.remember" id="remember-me" name="remember-me" type="checkbox"
                                                                class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                                                            <label for="remember" class="ml-2 block text-sm text-slate-900">Remember me</label>
                                                        </div>

                                                        <div class="text-sm">
                                                            <a href="/forgot-password"
                                                            class="font-medium text-teal-300 hover:text-teal-100">
                                                                Forgot your password?
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="justify-between flex items-end ">
                                                        <button @click.prevent="submit"
                                                                type="submit"
                                                                class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-7 h-7">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                                            </svg>
                                                            <span>Sign in</span>
                                                        </button>
                                                        <span class="text-sm">
                                                            <Link href="/catalyst-explorer/register" class="font-bold text-teal-600 hover:text-teal-500" preserve-scroll >Register</Link>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>