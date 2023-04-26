import {defineStore} from "pinia";
import {computed, ref, Ref } from "vue";
import {useStorage} from '@vueuse/core';
import Wallet from "../models/wallet";

export const useWalletStore = defineStore('wallet', () => {
    let walletData = ref<Wallet>(null)
    let wallet_name:Ref<string> = useStorage('wallet-name', '', localStorage, {mergeDefaults: true})
    
    async function saveWallet(wallet:Wallet) {
        walletData.value = wallet;
        wallet_name.value = wallet?.name
    }

    return{
        saveWallet,
        walletData,
        wallet_name
    }
});