import {defineStore} from "pinia";
import {ref, Ref } from "vue";
import {useStorage} from '@vueuse/core';
import Wallet from "../models/wallet";

export const useWalletStore = defineStore('wallet', () => {
    let walletData = ref<Wallet>(null)
    let walletName:Ref<string> = useStorage('wallet-name', '', localStorage, {mergeDefaults: true})

    async function saveWallet(wallet:Wallet) {
        walletData.value = wallet;
        walletName.value = wallet?.name
    }

    return{
        saveWallet,
        walletData,
        walletName: walletName
    }
});
