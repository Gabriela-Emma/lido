<template>
     <button @click.prevent="disconnectWallet()" 
            class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
        {{ $t("Disconnect wallet") }}
    </button>
</template>

<script lang="ts" setup>
import {storeToRefs} from "pinia";
import {useWalletStore} from "../../../catalyst-explorer/stores/wallet-store";

let walletStore = useWalletStore();

let disconnectWallet = () => {
    walletStore.disconnect();
}
</script>
