<template>
    <div v-show="open" style="display: none;" ref="target"
        class="absolute z-40 w-full mt-0 overflow-visible bg-white rounded-bl-sm rounded-br-sm shadow-md md:w-80">
        <span v-for="wallet in supportedWallets" @click.prevent="(open = false); action(wallet.name)"
            class="flex inline-flex items-center gap-2 px-4 py-2 text-xl font-semibold text-gray-700 hover:cursor-pointer hover:text-teal-600"
            role="menuitem" :disabled=!supports(wallet.name) tabindex="-1">
            <img :alt=wallet.altText class="w-6 h-auto" :src=wallet.imageSrc />
            <span :class="{ 'text-slate-300': !supports(wallet.name) }">
                {{ wallet.walletName }}
            </span>
            <slot></slot>
            <!-- <span class="text-sm text-slate-300 2xl:text-base" v-show="!supports(wallet.name)">
            Not Installed
        </span>
        <span class="text-sm text-slate-300 2xl:text-base" v-show="supports(wallet.name)">
            Sign tx with {{ wallet.walletName }}
        </span> -->
            <a v-bind:href="wallet.url" target="_blank" class="flex flex-row items-center gap-1 text-xs text-slate-400"
                v-show="!supports(wallet.name)">
                <span>Learn More</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">a
                    <path
                        d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                </svg>
            </a>
        </span>
    </div>
</template>

<script lang="ts" setup>
import { storeToRefs } from "pinia";
import { supports } from "../../../lib/utils/cardanoWallet";
import { useWalletStore } from '../../../catalyst-explorer/stores/wallet-store';
import { AvailableWallets } from '../../../lib/utils/wallets-list';


const props = withDefaults(
    defineProps<{
        open?: boolean,
    }>(),
    {
        open: false
    });



let walletStore = useWalletStore();
let { walletData } = storeToRefs(walletStore);
let { walletName } = storeToRefs(walletStore);

let supportedWallets;

if (walletName.value) {
    supportedWallets = [AvailableWallets.find((wallet) => wallet.name == walletName.value)]
} else {
    supportedWallets = AvailableWallets;
}



const emit = defineEmits<{
    (e: 'delagate', wallet: string): void,
}>();

let action = async (wallet) => {
    emit('delagate', wallet)
}

</script>
