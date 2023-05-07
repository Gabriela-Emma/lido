<script lang="ts">
import LayoutEarn from "../Shared/LayoutEarn.vue";

export default {
    layout: LayoutEarn
};
</script>
<template>
    <section class="py-4 sm:py-8 md:pb-20 md:pt-16 pb-16 xl:pb-36 2xl:pt-24 bg-opacity-5 text-white overflow-visible z-5">
        <div class="container">
           Ways to earn
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, computed} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';
import User from "../../global/Shared/Models/user";
import {storeToRefs} from "pinia";
import {useWalletStore} from "../../catalyst-explorer/stores/wallet-store";
const ConnectWallet = defineAsyncComponent(() =>import('../../global/Shared/Components/ConnectWallet.vue'));

let walletStore = useWalletStore();
const user = computed(() => usePage().props.user as User);
let {walletData} = storeToRefs(walletStore);

const $utils: any = inject('$utils');

function register() {
    let form = useForm({
        email: user.value.email,
        wallet_address: walletData.value?.address,
        wallet_stake_address: walletData.value?.stakeAddress
    });

    const baseUrl = usePage().props.base_url;
    form.post(`${baseUrl}/api/earn/learn/register`, {
        preserveState: false,
        preserveScroll: false
    });
}

</script>
<style scoped>
:deep(li) {
    list-style: disc;
}

:deep(ul) {
    margin-left: 2rem;
}
</style>
