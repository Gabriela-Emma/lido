<template>
    <div>
        <button
            @click.prevent="open=!open"
            :aria-expanded="open"
            type="button"
            :class="[{'rounded-sm': !open},backgroundColor]"
            class="relative inline-flex items-center justify-between gap-2 px-3 py-2 font-medium text-white rounded-sm menu-link xl:text-xl 3xl:text-2xl">
            <span
                v-show="walletLoading && walletName"
                class="flex items-center justify-center w-4 p-1 bg-white rounded-full bg-opacity-90">
                <svg
                    class="relative w-3 h-3 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                    viewBox="0 0 24 24"></svg>
            </span>

            <span class="flex items-center gap-2 tracking-wide">
                <span class="text-sm" v-show="!wallet?.address">Connect Your Wallet</span>
                <span class="text-sm" v-show="wallet?.address">{{wallet?.name.charAt(0).toUpperCase() + wallet?.name.slice(1)}} Connected</span>
                <span class="text-slate-100" aria-hidden="true">&darr;</span>
            </span>
        </button>

        <div v-if="unsupportedNetwork" class="p-1 text-xs text-center text-red-600">
            <span class="underline">{{ unsupportedNetworkRes }} try again!</span>
        </div>

        <div
            v-show="open"
            style="display: none;"
            ref="target"
            class="absolute z-40 w-48 mt-3 overflow-visible bg-white rounded-bl-sm rounded-br-sm shadow-md">
            <div class="flex flex-col items-center gap-2 py-1 divide-y divide-slate-800 divide-opacity-40" role="none">
                <a v-for="wallet in AvailableWallets" href="#" @click.prevent="(open = !open); supports(wallet.name) ? enableWallet(wallet.name) : ''"
                   class="inline-flex w-full gap-2 px-4 py-2 text-xl text-gray-700"
                   :class="{'hover:cursor-not-allowed' : !supports(wallet.name)}"
                   role="menuitem"
                   :disabled="!supports(wallet.name)"
                   tabindex="-1">
                    <img :alt="wallet.altText" class="w-6 h-auto"
                         :src="wallet.imageSrc"/>
                    <span>{{wallet.walletName}}</span>
                    <span class="text-xs text-slate-300" v-show="!supports(wallet.name)">Not Installed</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {defineEmits, ref, Ref} from 'vue'
import {onClickOutside} from '@vueuse/core';
import {storeToRefs} from "pinia";
import WalletService from "@/global/services/wallet-service";
import Wallet from "@apps/catalyst-explorer/models/wallet";
import { useWalletStore } from "@/global/stores/wallet-store";
import {AvailableWallets} from "@/global/utils/wallets-list";

const props = withDefaults(
    defineProps<{
        backgroundColor?: string,
        autoConnect?: boolean
    }>(),
    {
        backgroundColor: 'bg-teal-700',
        autoConnect: true
    });
const emit = defineEmits<{
    (e: 'walletUpdated', wallet: Wallet): void
}>();

let open: Ref<boolean> = ref(false);
let backgroundColor = ref(props.backgroundColor);

// check for supported wallet
const walletService = new WalletService();
const supports = walletService.supports


// set the wallet data
let walletLoading = ref(false);
let walletData = {} as Wallet;

let walletStore = useWalletStore();
let {walletData: wallet} = storeToRefs(walletStore);
let {walletName} = storeToRefs(walletStore);

let unsupportedNetwork = ref(false);
let unsupportedNetworkRes = ref(null);

async function enableWallet(wallet_name: string) {
    walletLoading.value = true;
    unsupportedNetwork.value = false;
    let walletData = {
        name: wallet_name
    } as Wallet;
    try {
        let connectRes = await walletService.connectWallet(wallet_name)
        if(connectRes){
            unsupportedNetwork.value = true;
            unsupportedNetworkRes.value = connectRes;
            walletLoading.value = false;
        }
        walletData = {
            ...walletData,
            ...await getWalletAddress(),
        }
        await walletStore.saveWallet(walletData);
        walletLoading.value = false;
        emit('walletUpdated', walletData);
    } catch (e) {
        console.error(e);
        wallet.value = null;
        walletName.value = null;
    }
}

async function getWalletAddress(): Promise<Wallet> {
    return {
        address: await walletService.getAddress(),
        stakeAddress: await walletService.getStakeAddress()
    } as Wallet
}

if (props.autoConnect && walletName.value && supports(walletName.value)) {
    enableWallet(walletName.value)
}

const target = ref(null);
onClickOutside(target, (event) => open.value = false);
</script>
