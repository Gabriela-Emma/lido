<script lang="ts">
import LayoutEarn from "../Shared/LayoutEarn.vue";

export default {
    layout: LayoutEarn
};
</script>
<template>
    <div class="flex flex-row gap-3 justify-between p-5">
        <div class="flex flex-col">
            <h1 class="text-md md:text-2xl xl:text-4xl 2xl:text-5xl">CCV4 <span class="text-black">Voting Giveaway</span>
            </h1>
            <p class="text-md xl:text-lg xl:max-2-4xl">
                Did you vote during the CCv4 Catalyst Circle Voting? If so, you may be eligible for a reward.
            </p>
        </div>
    </div>

    <div class="relative">
        <section class="border-t border-teal-300 p-6">
            <div class="max-w-2xl">
                Working to re-enable the ccv4 catalyst circle voting giveway of $hostky and $discoin provided by those
                communities as a reward wallets that participated in voting. <span class="text-black">Please check back soon.</span>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import {inject, computed} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import {defineAsyncComponent} from 'vue';
import User from "../../global/Shared/Models/user";
import {storeToRefs} from "pinia";
import {useWalletStore} from "../../catalyst-explorer/stores/wallet-store";

const ConnectWallet = defineAsyncComponent(() => import('../../global/Shared/Components/ConnectWallet.vue'));

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
