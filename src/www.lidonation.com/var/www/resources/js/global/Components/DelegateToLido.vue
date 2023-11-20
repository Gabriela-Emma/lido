<template>
    <div class="z-40 bg-white rounded-bl-sm rounded-br-sm " :class="{'shadow-md ':column}">
        <div v-if="column" class="md:w-96">
            <button @click="toggle()"  :class="{ 'rounded-sm': !open }" type="button"
                class="flex items-center w-full gap-2 px-4 py-2 text-xl font-semibold text-gray-700 hover:cursor-pointer hover:text-teal-600">
                <span>{{title}}</span>
            </button>
            <div v-if="!!open" ref="target" class="absolute z-40 w-full mt-0 overflow-visible bg-white rounded-bl-sm rounded-br-sm shadow-md ">
                <div class="inline-flex items-center gap-2 px-4 py-2 text-xl font-semibold text-gray-700 hover:cursor-pointer hover:text-teal-600"
                    v-for="wallet in supportedWallets"
                    @click ="delegate(wallet.name); open = !open "
                    role="menuitem"
                    :disabled=!walletService.supports(wallet.name) >
                    <img :alt=wallet.altText class="w-6 h-auto" :src=wallet.imageSrc />
                    <span :class="{ 'text-slate-300': !walletService.supports(wallet.name) }">
                        {{ wallet.walletName }}
                    </span>
                    <span class="text-sm text-slate-300 2xl:text-base break-keep" v-show="!walletService.supports(wallet.name)">
                        Not Installed
                    </span>
                    <span class="text-sm text-slate-300 2xl:text-base" v-show="walletService.supports(wallet.name)">
                        Sign tx with {{ wallet.walletName }}
                    </span>
                    <a v-bind:href="wallet.url" target="_blank"
                        class="flex flex-row items-center gap-1 text-xs text-slate-400" v-show="!walletService.supports(wallet.name)">
                        <span>Learn More</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">a
                            <path
                                d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                            <path
                                d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div v-else class="p-3">
            <div class="mt-8 grid md:grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-0 lg:grid-cols-2">
                <div class="flex items-center justify-center col-span-1 gap-3">
                    <h2 class="text-2xl 2xl:text-3xl"><span class="font-bold">{{title}}</span></h2>
                </div>
                <div v-for="wallet in supportedWallets" @click.prevent=" delegate(wallet.name)"
                    class="flex items-center justify-center col-span-1 gap-3 px-8 py-8 bg-slate-50">
                    <img :alt=wallet.altText class="w-6 h-auto mr-2" :src=wallet.imageSrc />
                    <span :class="{ 'text-slate-300': !walletService.supports(wallet.name) }">
                        {{ wallet.walletName }}
                    </span>
                    <span class="text-sm text-slate-300 2xl:text-base break-keep" v-show="!walletService.supports(wallet.name)">
                        Not Installed
                    </span>
                    <span class="text-sm text-slate-300 2xl:text-base" v-show="walletService.supports(wallet.name)">
                        Sign tx with {{ wallet.walletName }}
                    </span>
                    <a v-bind:href="wallet.url" target="_blank"
                        class="flex flex-row items-center gap-1 text-xs text-slate-400" v-show="!walletService.supports(wallet.name)">
                        <span>Learn More</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">a
                            <path
                                d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                            <path
                                d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup >
import { ref, Ref } from 'vue';
import { storeToRefs } from "pinia";
import WalletService from '@/global/services/wallet-service';
import { useWalletStore } from '@/global/stores/wallet-store';
import { onClickOutside } from '@vueuse/core';
import WalletList from './WalletList.vue'
import { AvailableWallets } from '@/global/utils/wallets-list';
import SupportedWallet from "@/global/models/supported-wallets";

const props = withDefaults(
    defineProps<{
        column?: boolean
        title?:string
    }>(),
    {
        title: 'Delegate with 1-click!',
        column:true
    });

let open = ref<boolean>(false)



let walletStore = useWalletStore();
let { walletData } = storeToRefs(walletStore);
let { walletName } = storeToRefs(walletStore);
const walletService = new WalletService()



let supportedWallets: SupportedWallet[];

if (walletName.value) {
    supportedWallets = [AvailableWallets.find((wallet) => wallet.name == walletName.value)]
} else {
    supportedWallets = AvailableWallets;
}


// wallet store

let delegating: Ref<boolean> = ref(false);
let delegationTransactionId = ref(null);

let toggle = () => {
    open.value = open.value ? false : true ;
}


let delegate = async (wallet: string) => {
    delegating.value = true;
    try {
        delegationTransactionId.value = await walletService.delegate(wallet);
    } catch (e) {
        console.error(e.message);
    }
    delegating.value = false;
}


const target = ref(null);
onClickOutside(target, (event) => open.value = false);
</script>
