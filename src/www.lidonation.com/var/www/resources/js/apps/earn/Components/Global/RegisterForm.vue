<template>
    <div class="flex items-center justify-center h-screen bg-slate-100">
        <form v-if="user">
            <div class="p-6 bg-white rounded shadow-sm  w-96">
                <div class="flex-col mb-4 border-b " v-if="slots?.logo">
                    <slot name="logo"></slot>
                </div>
                <div>
                    <div class="flex justify-start mb-2 ">
                        <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-5xl 3xl:text-6xl text-slate-700">
                            {{ $t("Register") }} </h1>
                    </div>

                    <div v-if="!name" class="mb-2">
                        <label for="name" class="block text-sm font-medium text-slate-600">{{ $t("Name") }} </label>
                        <div class="mt-1">
                            <input v-model="name" v-text="form.errors.name" id="name" name="name" type="text"
                                   autocomplete="name" required
                                   class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.name" v-text="form.errors.name"
                                 class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>
                    <div v-if="email" class="mb-2">
                        <label for="email" class="block text-sm font-medium text-slate-600">{{
                                $t("Email address")
                            }} </label>
                        <div class="mt-1">
                            <input v-model="email" id="email" name="email" type="email" autocomplete="email" required
                                   disabled
                                   class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.email" v-text="form.errors.email"
                                 class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="twitter" class="block text-sm font-medium text-slate-600">{{
                                $t("Twitter")
                            }} </label>
                        <div class="mt-1">
                            <input v-model="twitter" id="twitter" name="twitter" type="twitter" autocomplete="twitter"
                                   placeholder="optional"
                                   class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.twitter" v-text="form.errors.twitter"
                                 class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="telegram" class="block text-sm font-medium text-slate-600">{{
                                $t("Telegram")
                            }} </label>
                        <div class="mt-1">
                            <input v-model="telegram" id="telegram" name="telegram" type="telegram"
                                   autocomplete="telegram" placeholder="optional"
                                   class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.telegram" v-text="form.errors.telegram"
                                 class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-3 ">
                        <div class="">
                            <button @click.prevent="submit" type="submit"
                                    class="flex items-center justify-center w-full gap-3 px-4 py-2 text-xl font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm 2xl:text-2xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                                </svg>
                                <span>{{ $t("Sign Up") }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form v-else>
            <div class="p-6 bg-white rounded shadow-sm ">
                <div class="flex-col mb-4 border-b " v-if="slots?.logo">
                    <slot name="logo"></slot>
                </div>
                <div>
                    <div class="flex justify-start mb-2 ">
                        <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-5xl 3xl:text-6xl text-slate-700">
                            {{ $t("Register") }} </h1>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="mb-2">
                            <label for="name" class="block text-sm font-medium text-slate-600">{{ $t("Name") }} </label>
                            <div class="mt-1">
                                <input v-model="form.name" v-text="form.errors.name" id="name" name="name" type="text"
                                    autocomplete="name" required
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.name" v-text="form.errors.name"
                                    class="mt-1 text-xs text-red-500"></div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="block text-sm font-medium text-slate-600">{{
                                    $t("Email address")
                                }} </label>
                            <div class="mt-1">
                                <input v-model="form.email" id="email" name="email" type="email" autocomplete="email" required
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.email" v-text="form.errors.email"
                                    class="mt-1 text-xs text-red-500"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="password" class="block text-sm font-medium text-slate-600">{{
                                    $t("Password")
                                }} </label>
                            <div class="mt-1">
                                <input v-model="form.password" name="password" type="password"
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.password" v-text="form.errors.password"
                                    class="mt-1 text-xs text-red-500"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-slate-600">{{ $t("Confirm Password") }} </label>
                            <div class="mt-1">
                                <input v-model="form.password_confirmation" name="password_confirmation" type="password"
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation"
                                    class="mt-1 text-xs text-red-500"></div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="twitter" class="block text-sm font-medium text-slate-600">{{
                                    $t("Twitter")
                                }} </label>
                            <div class="mt-1">
                                <input v-model="form.twitter" id="twitter" name="twitter" type="twitter" autocomplete="twitter"
                                    placeholder="optional"
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.twitter" v-text="form.errors.twitter"
                                    class="mt-1 text-xs text-red-500"></div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="telegram" class="block text-sm font-medium text-slate-600">{{
                                    $t("Telegram")
                                }} </label>
                            <div class="mt-1">
                                <input v-model="form.telegram" id="telegram" name="telegram" type="telegram"
                                    autocomplete="telegram" placeholder="optional"
                                    class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.telegram" v-text="form.errors.telegram"
                                    class="mt-1 text-xs text-red-500"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-3 ">
                        <div class="">
                            <button @click.prevent="submit" type="submit"
                                    class="flex items-center justify-center w-full gap-3 px-4 py-2 text-xl font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm 2xl:text-2xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                                </svg>
                                <span>{{ $t("Register") }}</span>
                            </button>
                        </div>

                        <div>
                            <div class="flex justify-center w-full gap-3 text-sm ">
                                <span>Already have an account{{ $t("") }}?</span>
                                <Link href="/earn/learn/login" class="font-bold text-teal-600 hover:text-teal-500"
                                      preserve-scroll> {{ $t("Sign in") }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import {storeToRefs} from "pinia";
import {Ref, inject, computed, ref, useSlots} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import {Link, router} from '@inertiajs/vue3';
import User from "@/global/models/user";
import { useWalletStore } from "@/global/stores/wallet-store";
import Wallet from "@apps/catalyst-explorer/models/wallet";
import route from "ziggy-js";

const slots = useSlots();
const $utils: any = inject('$utils');
const user = computed(() => usePage().props.user as User)

const props = defineProps({
    errors: Object
})

let name = ref(null);
let email = ref(null);
let wallet_address = ref(null);
let wallet_stake_address = ref(null);
let twitter = ref(null);
let telegram = ref(null);

let walletStore = useWalletStore();
let {walletData} = storeToRefs(walletStore);
let myWallet: Ref<Wallet> = computed(() => walletData.value);

if (user) {
    name.value = user.value?.name;
    email.value = user.value?.email;
    wallet_address.value = myWallet?.value?.address;
    wallet_stake_address.value = myWallet?.value?.stakeAddress;
    twitter.value = user.value?.twitter;
    telegram.value = user.value?.telegram;
}

let form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    wallet_address: wallet_address,
    wallet_stake_address: wallet_stake_address,
    twitter,
    telegram
});

const baseUrl = usePage().props?.ziggy?.url;
let submit = () => {
    form.post(`${baseUrl}/api/earn/learn/register`);
    // form.post(route("earnApi.register"));
}

// let submit = () => {
//     form.post(`${usePage().props.base_url}/api/earn/learn/register`, {
//         preserveScroll: true,
//         onSuccess: () => {
//             router.get(`${usePage().props.base_url}/sw/earn/learn/modules`)
//         }
//     })
// }

</script>
