<template>
     <div @click.prevent="disconnectWallet()">
        <slot></slot>
    </div>
</template>

<script lang="ts" setup>
import {useWalletStore} from "@/global/stores/wallet-store";

let walletStore = useWalletStore();

let disconnectWallet = () => {
    walletStore.disconnect();
}
</script>
