<template>
    <div>
        <button
            @click.prevent="open=!open"
            :aria-expanded="open"
            type="button"
            :class="[{'rounded-sm': !open},backgroundColor]"
            class="px-2 py-1.5 rounded-sm rounded-tl-sm rounded-tr-sm inline-flex justify-between gap-2  text-white menu-link font-semibold relative">
            <span
                v-show="walletLoading"
                class="flex items-center justify-center w-4 p-1 bg-white rounded-full bg-opacity-90">
                <svg
                    class="relative w-3 h-3 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                    viewBox="0 0 24 24"></svg>
            </span>

            <span class="flex items-center gap-2 tracking-wide" v-show="walletData?.handle">
                <span v-text="(walletData?.handle) + ' connected'"
                      class="text-sm text-slate-200 h-full border-primary-200 border-opacity-50 p-0.5 capitalize">
                </span>
                <span>
                    <!-- <span v-text="myWallet.balance"></span> -->
                    <!-- <span class="text-slate-100" aria-hidden="true">₳</span> -->
                </span>
            </span>

            <span class="flex gap-2 tracking-wide items-center" v-show="!walletData?.handle">
                <span>Connect Your Wallet</span>
                <span class="text-slate-100" aria-hidden="true">&darr;</span>
            </span>
        </button>

        <div v-if="unsupportedNetwork" class="text-xs text-red-600 p-1 text-center">
            <span class="underline">{{ unsupportedNetworkRes }} try again!</span>
        </div>

        <div
            v-show="open"
            style="display: none;"
            ref="target"
            class="absolute z-40 w-48 mt-3 overflow-visible bg-white rounded-bl-sm rounded-br-sm shadow-md">
            <div class="flex flex-col items-center gap-2 py-1 divide-y divide-slate-800 divide-opacity-40" role="none">
                <a v-for="wallet in AvailableWallets" href="#" @click.prevent="(open = !open); supports(wallet.name) ? enableWallet(wallet.name) : ''"
                   class="inline-flex block w-full gap-2 px-4 py-2 text-xl text-gray-700"
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
import {defineEmits, ref, Ref} from 'vue';
import WalletService from '../../../lib/services/WalletService';
import CardanoService from '../../../lib/services/CardanoService';
import {useWalletStore} from '../../../catalyst-explorer/stores/wallet-store';
import Wallet from '../../../catalyst-explorer/models/wallet';
import {C} from "lucid-cardano";
import {onClickOutside} from '@vueuse/core';
import {storeToRefs} from "pinia";
import {supports} from "../../../lib/utils/cardanoWallet";
import { AvailableWallets } from '../../../lib/utils/wallets-list';

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

// set the wallet data
let walletLoading = ref(false);
let walletData = {} as Wallet;

let walletStore = useWalletStore();
let {walletData: wallet} = storeToRefs(walletStore);
let {walletName} = storeToRefs(walletStore);

let unsupportedNetwork = ref(false);
let unsupportedNetworkRes = ref(null);

async function enableWallet(walletName: string) {
    walletLoading.value = true;
    unsupportedNetwork.value = false;
    let walletData = {
        name: walletName
    } as Wallet;
    try {
        let connectRes = await walletService.connectWallet(walletName)
        if(connectRes){
            unsupportedNetwork.value = true;
            unsupportedNetworkRes.value = connectRes;
            walletLoading.value = false;
        }
        walletData = {
            ...walletData,
            ...await getWalletAddress(),
            // ...await getWalletBalance(),
            // ...await getHandle(walletData.stakeAddress)
        }
        await walletStore.saveWallet(walletData);
        walletLoading.value = false;
        emit('walletUpdated', walletData);
    } catch (e) {
        console.error(e);
    }
}

async function getWalletAddress(): Promise<Wallet> {
    return {
        address: await walletService.getAddress(),
        stakeAddress: await walletService.getStakeAddress()
    } as Wallet
}

async function getWalletBalance(): Promise<Wallet> {
    let walletBalance;
    walletBalance = await walletService.getBalance(walletName.value);
    walletBalance = C.Value.from_bytes(Buffer.from(walletBalance, 'hex')).coin().to_str();

    if (!!walletBalance) {
        return {
            lovelacesBalance: walletBalance,
            balance: (walletBalance / (1000000)).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
        }
    }

    return {
        lovelacesBalance: null,
        balance: null
    } as Wallet;

}

async function getHandle(stakeAddress: string): Promise<Wallet> {
    try {
        let cardanoService = new CardanoService();
        return {handle: await cardanoService.getHandle(stakeAddress)} as Wallet;
    } catch (e) {
        console.error(e);
    }
    return {handle: null} as Wallet;
}

if (props.autoConnect && walletName.value && supports(walletName.value)) {
    enableWallet(walletName.value)
}

const target = ref(null);
onClickOutside(target, (event) => open.value = false);
</script>
