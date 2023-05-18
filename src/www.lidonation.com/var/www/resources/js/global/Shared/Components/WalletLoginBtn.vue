<template>
    <div class="mt-3">
        <a v-show="wallet?.name"
           href="#"
           @click="loginUser"
           class="flex w-full gap-3 items-center justify-center mx-auto py-2 px-4 rounded-sm shadow bg-slate-200  text-lg xl:text-xl 2xl:text-2xl font-medium text-teal-800 ">
            <WalletLogo :wallet="wallet" />
            <span class="">Sign in with <span v-text="wallet?.name"></span></span>
        </a>

        <div v-show="!wallet?.name"
             class="flex w-full gap-3 items-center justify-center mx-auto py-2 px-4 xl:text-xl 2xl:text-2xl font-medium">
            <ConnectWallet />
        </div>
    </div>

</template>

<script lang="ts" setup>
import {defineAsyncComponent} from 'vue';
import {AxiosError} from 'axios';
import {storeToRefs} from "pinia";
import {useWalletStore} from "../../../catalyst-explorer/stores/wallet-store";
import User from "../Models/user";
import WalletLogo from "./WalletLogo.vue";

const ConnectWallet = defineAsyncComponent(() => import('./ConnectWallet.vue'));

const props = withDefaults(
    defineProps<{
        role?: string,
        redirect?: string,
    }>(),
    {
        role: 'catalyst-explorer',
    },
);

let walletStore = useWalletStore();
let {walletData: wallet} = storeToRefs(walletStore);

const emit = defineEmits<{
    (e: 'walletError', error: AxiosError | any): void,
    (e: 'walletLoginSuccessful', user: User | any): void,
}>();

let loginUser = async () => {
    const {walletLogin} = await import('../../../lib/utils/walletLogin');
    const data = {
        stake_address: wallet?.value?.stakeAddress
    };
    try {
        const user = await walletLogin(
            wallet?.value?.name,
            wallet?.value?.stakeAddress,
            props.redirect,
            data
        );
        emit('walletLoginSuccessful', user);
    } catch (e: AxiosError | any) {
        console.log(e);
        emit('walletError', 'error connecting with wallet');
    }
}
</script>
