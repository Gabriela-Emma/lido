<div class="flex flex-1 h-full">
    <div class="flex flex-col justify-center min-w-[28rem] w-6/12" x-data="cardanoWallet" @wallet-loaded.window="walletLoaded($event?.detail)">
        <div class="mx-auto w-full max-w-sm lg:w-96" x-show="working" x-transition>
            <x-theme.spinner theme="teal" square="16" />
        </div>

        <div x-show="!working" x-transition>
            <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none xl:px-20 " x-transition x-show="!walletName || !(assets?.length > 0)">
                <div class="flex flex-col gap-3" x-show="!working">
                    <x-cardano.connect-wallet theme="eggplant"/>
                    <div class="flex flex-col gap-2 text-slate-800 text-sm" x-show="walletName && assets && !(assets?.length > 0)">
                        <p>
                            We couldn't find any partner NFTs in your wallet.
                        </p>
                        <p class="font-bold">Try connecting another wallet</p>
                    </div>
                </div>
            </div>

            <template x-transition x-if="registering && walletName && assets?.length > 0">
                <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none xl:px-20 w-115">
                    @include('livewire.partners.registration-form')
                </div>
            </template>

            <template x-transition x-if="!registering && walletName && assets?.length > 0">
                <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none xl:px-20">
                    <div class="mx-auto w-full max-w-sm lg:w-96">
                        <div>
                            <h2 class="mt-6 text-3xl font-bold tracking-tight text-slate-900">
                                Sign in to your account
                            </h2>
                            <p class="mt-2 text-sm text-slate-600">
                                Or
                                <a href="#" class="font-medium text-teal-600 hover:text-teal-500">
                                    Learn about partnering with lido.
                                </a>
                            </p>
                        </div>

                        <div class="mt-8 flex flex-col gap-6">
                            <div>
                                <div class="text-center">
                                    <p class="text-xs font-medium text-slate-700 text-left mb-1">
                                        Sign in with your hot wallet
                                    </p>
                                    <x-cardano.wallet-login-btn classes='border border-slate-400 hover:bg-slate-100' />
                                </div>

                               <div class="relative mt-6">
                                   <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                       <div class="w-full border-t border-slate-400"></div>
                                   </div>
                                   <div class="relative flex justify-center text-sm">
                                       <span class="bg-white px-2 text-slate-500">Or continue with</span>
                                   </div>
                               </div>
                               <div class="">
                                   @include('livewire.partners.login-form')
                               </div>
                            </div>

                            <div class="-mt-4">
                                <button type="submit"
                                        @click="registerPartner()"
                                        class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-eggplant-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-eggplant-700 focus:outline-none focus:ring-2 focus:ring-eggplant-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                    </svg>
                                    <span>Register</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="relative hidden w-0 flex-1 lg:block">
        <section class="absolute bottom-4 w-full bg-transparent z-40 pointer-events-none">
            <x-notice />
        </section>
        <img class="absolute inset-0 h-full w-full object-cover" src="{{$randomNft->preview_link}}" alt="{{$randomNft->name}} NFT">
    </div>
</div>
