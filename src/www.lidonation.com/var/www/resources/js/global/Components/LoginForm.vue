<template>
    <div :class="{
        'flex items-center justify-center h-screen': !embedded,
        'bg-slate-100': forRewards === false
    }" class="login-form-wrapper">
        <form>
            <div class="p-6 rounded min-w-[380px] w-full" :class="{ 'bg-white shadow-sm ': forRewards === false }">
                <div class="flex-col mb-4 border-b " v-if="showLogo">
                    <div class="flex items-center justify-center mb-4">
                        <img alt="catalyst explorer logo" :src="$utils.assetUrl('img/catalyst-explorer-logo.jpg')"
                            class="h-40" />
                    </div>
                </div>

                <div>
                    <div class="flex justify-start mb-2 " v-show="forRewards === false">
                        <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-5xl 3xl:text-6xl text-slate-700">
                            {{ $t("Login") }} </h1>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="block text-sm font-medium text-slate-700">{{
                            $t("Email address")
                        }}</label>
                        <div class="mt-1 ">
                            <input v-model="form.email" id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.email" v-text="form.errors.email" class="mt-1 text-xs text-red-500">
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="block text-sm font-medium text-slate-700">{{ $t("Password") }}</label>
                        <div class="mt-1">
                            <input v-model="form.password" id="password" name="password" type="password"
                                autocomplete="password" required
                                class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                            <div v-if="form.errors.password" v-text="form.errors.password"
                                class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 mb-2">
                        <div class="flex items-center">
                            <input v-model="form.remember" id="remember-me" name="remember-me" type="checkbox"
                                class="w-4 h-4 text-teal-600 rounded border-slate-300 focus:ring-teal-500">
                            <label for="remember" class="block ml-2 text-sm text-slate-900">{{
                                $t("Remember me")
                            }}</label>
                        </div>

                        <div class="text-sm">
                            <a href="/forgot-password" class="font-medium text-teal-300 hover:text-teal-100">
                                {{ $t("Forgot your password") }}?
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-2">
                        <button @click.prevent="submit" type="submit"
                            class="flex items-center justify-center w-full gap-3 px-4 py-2 text-xl font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm 2xl:text-2xl hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            <span>{{ $t("Sign in") }}</span>
                        </button>
                        <span class="text-sm">
                            <button type="button" @click.prevent="emit('go-to-register')"
                                class="font-bold text-teal-600 hover:text-teal-500" preserve-scroll>{{ $t("Register")
                                }}</button>
                        </span>
                    </div>
                </div>
                <Divider v-show="showDivider" />
                <div v-show="showWalletBtn" class="flex flex-col items-center">
                    <div v-if="walletError" v-text="walletError" class="my-1 text-sm text-red-500"></div>
                    <WalletLoginBtn @walletLoginSuccessful="emit('success', $event)"
                        @walletError="handleWalletError($event)" />
                </div>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { inject, Ref, ref } from "vue";
import WalletLoginBtn from './WalletLoginBtn.vue';
import { storeToRefs } from 'pinia';
import Divider from './Divider.vue';
import {useWalletStore} from "@/global/stores/wallet-store";
import User from "@/global/models/user";

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        errors?: Object,
        showLogo?: boolean,
        embedded?: boolean,
        showWalletBtn?: boolean,
        showDivider?: boolean,
        forRewards?: boolean,
    }>(),
    {
        showLogo: true,
        embedded: false,
        showWalletBtn: true,
        showDivider: true,
        forRewards: false
    },
);

let form = useForm({
    password: '',
    email: '',
    remember: false
})

let walletStore = useWalletStore();
let { walletName } = storeToRefs(walletStore);

let walletError = ref('');
let handleWalletError = (error) => {
    walletError.value = error.message
}

const emit = defineEmits<{
    (e: 'setForm', form): void
    (e: 'submit'):void
    (e: 'go-to-register'):void
    (e: 'success', user: User):void
}>();

let submit = () => {
    emit('setForm', form)
    emit('submit');
}
</script>
