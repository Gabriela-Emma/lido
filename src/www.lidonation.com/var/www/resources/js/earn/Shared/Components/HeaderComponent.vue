<template>
    <header class="container">
        <div class="flex flex-wrap items-center gap-4 py-6">
            <div class="flex items-center gap-4">
                <div class="w-40 lg:w-32">
                    <img alt="catalyst explorer logo" :src="$utils.assetUrl('img/catalyst-explorer-logo.jpg')"/>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-4xl text-slate-700">
                        {{ $t(titleName0) }} <span class="text-teal-600"> {{ $t(titleName1) }}</span>
                    </h1>
                    <p class="text-slate-600">
                        {{ $t(subTitle) }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-1 xl:ml-auto" v-if="!!user$">
                <p>{{ $t('Welcome back') }}, <strong>{{ user$?.name }}</strong></p>
                <ul class="flex items-center justify-end gap-4">
                    <li>
                        <Link class="flex items-center gap-1"
                              :href="$utils.localizeRoute('catalyst-explorer/my/dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                            <span>{{ $t('dashboard') }}</span>
                        </Link>
                    </li>
                    <li>
                        <Link @onClick="logout" type="button" class="flex items-center gap-1 font-bold text-teal-600 hover:text-red-600" as="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="relative w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                            </svg>
                            <span>{{ $t('logout') }}</span>
                        </Link>
                    </li>
                </ul>
            </div>

            <div class="xl:ml-auto" v-else>
                <Link :href="$utils.localizeRoute('catalyst-explorer/auth/login')"
                 @onSuccess="login($event)" as="button" type="button"
                      class="inline-flex items-center justify-center gap-1 px-3 py-2 font-medium border rounded-sm border-slate-800 xl:text-xl 3xl:text-2xl text-slate-800 hover:bg-slate-200 focus:outline-none focus:ring-0 focus:ring-offset-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                    <span>{{ $t('Sign in') }}</span>
                </Link>
            </div>
        </div>
    </header>
</template>

<script lang="ts" setup>
import {inject} from 'vue'
import {Link} from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { useUserStore } from '../../../global/Shared/store/user-store';

const $utils: any = inject('$utils');

withDefaults(
    defineProps<{
        titleName0: String,
        titleName1: String,
        subTitle: String
    }>(), {});

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);

function logout() {
   userStore.logout();
}

function login(event) {
    console.log(event);
//    userStore.logout();
}
</script>
