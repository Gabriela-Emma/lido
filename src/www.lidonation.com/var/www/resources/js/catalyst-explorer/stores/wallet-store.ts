import {defineStore} from "pinia";
import {computed, ref, Ref } from "vue";
import {useStorage} from '@vueuse/core';
import Wallet from "../models/wallet";

export const useWalletStore = defineStore('wallet', () => {
    let walletData = ref<Wallet>(null)
    
    async function saveWallet(wallet:Wallet) {
        walletData.value = wallet;
    }


    return{
        saveWallet,
        walletData
    }
});