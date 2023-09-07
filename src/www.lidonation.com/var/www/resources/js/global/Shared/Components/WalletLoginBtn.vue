<template>
    <div class="mt-3">
        <a v-show="wallet?.name" href="#" @click="loginUser"
            class="flex items-center justify-center w-full gap-3 px-4 py-2 mx-auto text-lg font-medium text-teal-800 rounded-sm shadow bg-slate-200 xl:text-xl 2xl:text-2xl ">
            <WalletLogo :wallet="wallet" />
            <div class="output">Sign in with <span v-if="signTx"> hardware</span> wallet </div>
        </a>

        <div v-show="!wallet?.name"
            class="flex items-center justify-center w-full gap-3 px-4 py-2 mx-auto font-medium xl:text-xl 2xl:text-2xl">
            <ConnectWallet />
        </div>
    </div>

    <DisconnectWalletBtn v-if="wallet?.name" class="my-1">
        <button type="button" class="text-sm text-slate-800 hover:text-slate-800">
            {{ $t("Disconnect") }} {{ wallet?.name }}
        </button>
    </DisconnectWalletBtn>

    <div>
        <Toggle v-model="signTx" offLabel="Use hardware wallet" onLabel="Use hot wallet" :classes="{
            container: 'inline-block rounded-xl outline-none focus:ring focus:ring-teal-500 focus:ring-opacity-40 w-48',
            toggle: 'flex w-full h-6 rounded-xl relative cursor-pointer transition items-center box-content border-0 text-xs lg:text-sm xl:text-md leading-none',
            toggleOn: 'bg-teal-600 border-teal-600 justify-start font-semibold text-white',
            toggleOff: 'bg-slate-200 border-slate-200 justify-end font-semibold text-slate-700',
            handle: 'inline-block bg-white w-5 h-5 top-0 rounded-xl absolute transition-all',
            handleOn: 'left-full transform -translate-x-full',
            handleOff: 'left-0',
            handleOnDisabled: 'bg-slate-100 left-full transform -translate-x-full',
            handleOffDisabled: 'bg-slate-100 left-0',
            label: 'text-center w-auto px-3 border-box whitespace-nowrap select-none',
        }" />
    </div>
</template>

<script lang="ts" setup>
import { defineAsyncComponent, ref } from 'vue';
import { AxiosError } from 'axios';
import { storeToRefs } from "pinia";
import { useWalletStore } from "../../../catalyst-explorer/stores/wallet-store";
import User from "../Models/user";
import WalletLogo from "./WalletLogo.vue";
import Toggle from '@vueform/toggle';
import DisconnectWalletBtn from '../../Shared/Components/DisconnetWalletBtn.vue'


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

let signTx = ref(false);

let walletStore = useWalletStore();
let { walletData: wallet } = storeToRefs(walletStore);

const emit = defineEmits<{
    (e: 'walletError', error: AxiosError | any): void,
    (e: 'walletLoginSuccessful', user: User | any): void,
}>();

let loginUser = async () => {
    const { messageLogin, txLogin } = await import('../../../lib/utils/walletLogin');
    const data = {
        stake_address: wallet?.value?.stakeAddress
    };
    try {
        if (signTx.value) {
            const user = await txLogin(
                wallet?.value?.name,
                wallet?.value?.stakeAddress,
                props.redirect,
                data
            );
            emit('walletLoginSuccessful', user);
        }
        const user = await messageLogin(
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
