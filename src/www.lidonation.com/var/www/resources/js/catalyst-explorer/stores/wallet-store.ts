import {defineStore} from "pinia";
import {computed, Ref } from "vue";
import {useStorage} from '@vueuse/core';
import Wallet from "../models/wallet";

export const useWalletStore = defineStore('wallet', () => {
    let walletData:Ref<Wallet> = useStorage('wallet-data', {}, localStorage, {mergeDefaults: true});
    
    async function saveWallet(wallet:Wallet) {
        walletData.value = wallet;
    }

    const walletArray = computed(() => Object.values(walletData.value));

    return{
        saveWallet,
        wallet:walletArray 
    }
});