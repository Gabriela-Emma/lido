<template>
    <div class="flex items-center justify-center h-screen bg-slate-100">
        <form >
            <div class=" bg-white shadow-sm  rounded  p-6 w-96">
                    <div class=" flex-col  mb-4 border-b">
                        <div class="flex items-center justify-center mb-4">
                            <img alt="catalyst explorer logo" :src="$utils.assetUrl('img/catalyst-explorer-logo.jpg')"
                                class="h-40"/>
                        </div>
                    </div>
                <div>
                    <div class=" flex justify-start mb-2">
                        <h1 class="text-2xl lg:text-3xl 2xl:text-5xl 3xl:text-6xl font-semibold text-slate-700"> {{ $t("Register") }} </h1>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-slate-600">{{ $t("Name") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.name" v-text="form.errors.name" id="name" name="name" type="text" autocomplete="name" required
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.name" v-text="form.errors.name"
                            class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="block text-sm font-medium text-slate-600">{{ $t("Email address") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.email" id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.email" v-text="form.errors.email"
                            class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="wallet_address" class="block text-sm font-medium text-slate-600">{{ $t("ADA Wallet Address") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.wallet_address" id="wallet_address" name="wallet_address" type="wallet_address" autocomplete="wallet_address" required
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.wallet_address" v-text="form.errors.wallet_address"
                            class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="password" class="block text-sm font-medium text-slate-600">{{ $t("Password") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.password" name="password" type="password"
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.password" v-text="form.errors.password"
                                class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-600">{{ $t("Confirm Password") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.password_confirmation"  name="password_confirmation" type="password"
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation"
                                class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="twitter" class="block text-sm font-medium text-slate-600">{{ $t("Twitter") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.twitter" id="twitter" name="twitter" type="twitter" autocomplete="twitter"
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.twitter" v-text="form.errors.twitter"
                            class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="telegram" class="block text-sm font-medium text-slate-600">{{ $t("Telegram") }} </label>
                        <div class="mt-1">
                            <input  v-model="form.telegram" id="telegram" name="telegram" type="telegram" autocomplete="telegram"
                                class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.telegram" v-text="form.errors.telegram"
                            class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-col gap-2 ">
                        <div class="">
                            <button @click.prevent="submit" type="submit"
                                class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                            <span>{{ $t("Register") }}</span>
                            </button>
                        </div>

                        <div>
                            <div class="flex gap-3 text-sm w-full justify-center ">
                                <span>Already have an account{{ $t("") }}?</span>
                                <Link href="/earn/learn/login" class="font-bold text-teal-600 hover:text-teal-500" preserve-scroll> {{ $t("Sign in") }}</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import {useForm, usePage} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import {inject} from "vue";
const $utils: any = inject('$utils');

const props=defineProps({
    errors:Object
})
let form= useForm({
    name:'',
    email:'',
    password:'',
    password_confirmation:'',
    wallet_address:'',
    twitter:'',
    telegram:''
});

const baseUrl = usePage().props.base_url;
let submit= () =>{
     form.post(`${baseUrl}/api/earn/learn/register`);
}

</script>
