<template>
    <div>
        <!-- Button -->
        <button @click="toggle()" :aria-expanded="open" :class="{ 'rounded-sm': !open }">
            <slot name="button-title"></slot>
        </button>

        <!-- Panel -->
        <WalletList :open="open" @delagate="delegate($event)">

        </WalletList>
    </div>
</template>

<script lang="ts" setup >
import { ref, Ref } from 'vue';
import { storeToRefs } from "pinia";
import WalletService from '@/global/services/wallet-service';
import { useWalletStore } from '@/global/stores/wallet-store';
import { onClickOutside } from '@vueuse/core';
import WalletList from './WalletList.vue'

let open = ref(false)
// wallet store
let walletStore = useWalletStore();
let { walletData } = storeToRefs(walletStore);
let { walletName } = storeToRefs(walletStore);

const walletService = new WalletService();
let delegating: Ref<boolean> = ref(false);
let delegationTransactionId = ref(null);



let delegate = async (wallet) => {
    delegating.value = true;
    try {
        delegationTransactionId.value = await walletService.delegate(wallet);
    } catch (e) {
        console.error(e.message);
    }
    delegating.value = false;
}

let toggle = () => {
    open.value = !open.value;
}

const target = ref(null);
onClickOutside(target, (event) => open.value = false);
</script>
