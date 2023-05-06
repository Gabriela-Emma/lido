<template>
     <div @click.prevent="disconnectWallet()">
        <slot></slot> 
    </div>
</template>

<script lang="ts" setup>
import {storeToRefs} from "pinia";
import {useWalletStore} from "../../../catalyst-explorer/stores/wallet-store";

let walletStore = useWalletStore();

let disconnectWallet = () => {
    walletStore.disconnect();
}
</script>
