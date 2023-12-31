<template>
    <header class="container"
        :class="[`bg-${color}`]"
    >
        <div class="flex flex-wrap items-center justify-between gap-4 py-6">
            <div class="flex items-center gap-4">
                <div class="w-40 rounded-sm lg:w-32">
                    <img alt="catalyst explorer logo" src="/img/catalyst-explorer-logo.jpg" />
                </div>
                <div>
                    <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-4xl text-slate-900">
                        {{ $t(titleName0) }} <span :class="{'text-white': color === 'teal-600', 'text-teal-600': color === 'white'}"> {{ $t(titleName1) }}</span>
                    </h1>
                    <div class="flex flex-row">
                        <p class="mr-3"
                        :class="{'text-white': color === 'teal-600', 'text-slate-600': color === 'white'}"
                        >
                            {{ $t(subTitle) }}
                        </p>
                        <slot />
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-end">
                <div class="mr-3">
                   <ConnectWallet />
                </div>
                <div>
                    <div class="flex flex-col gap-1 xl:ml-auto" v-if="!!user$">
                        <p>{{ $t('Welcome back') }}, <strong :class="{'text-slate-900': color === 'teal-600'}">{{ user$?.name }}</strong></p>
                        <ul class="flex items-center justify-end gap-4">
                            <li>
                                <Link class="flex items-center gap-1"
                                    :href="$utils.localizeRoute('catalyst-explorer/my/dashboard')"
                                    :class="{'text-white': color === 'teal-600', 'text-teal-600': color === 'white'}"
                                    >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span>{{ $t('dashboard') }}</span>
                                </Link>
                            </li>
                            <li>
                                <button @click.prevent="logout()"
                                    class="flex items-center gap-1 font-bold text-teal-600 hover:text-red-600" as="button"
                                    :class="{'text-white': color === 'teal-600', 'text-slate-600': color === 'white'}"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="relative w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    <span>{{ $t('logout') }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="xl:ml-auto" v-else>
                        <Link :href="$utils.localizeRoute('catalyst-explorer/utility-login')" @onSuccess="login($event)"
                            class="inline-flex items-center justify-center gap-1 px-3 py-2 font-medium border rounded-sm border-slate-800 xl:text-xl 3xl:text-2xl text-slate-800 hover:bg-slate-200 focus:outline-none focus:ring-0 focus:ring-offset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>{{ $t('Sign in') }}</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script lang="ts" setup>
import { inject } from 'vue'
import { Link } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import {useUserStore} from "@/global/stores/user-store";
import ConnectWallet from '@/global/Components/ConnectWallet.vue';

const $utils: any = inject('$utils');
const userStore = useUserStore();
let { user$ } = storeToRefs(userStore);

withDefaults(
    defineProps<{
        titleName0: String,
        titleName1: String,
        subTitle: String,
        color?: string,
    }>(), {
        color: 'white'
    });

function logout() {
    userStore.logout();
}

function login(event) {
    console.log(event);
    //    userStore.logout();
}
</script>
