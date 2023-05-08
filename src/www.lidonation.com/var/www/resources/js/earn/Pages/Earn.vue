<script lang="ts">
import LayoutEarn from "../Shared/LayoutEarn.vue";

export default {
    layout: LayoutEarn
};
</script>
<template>
    <div class="flex flex-row gap-3 justify-between p-5">
        <div class="flex flex-col md:flex-rowmd:gap-2md:items-end">
            <h1 class="text-md md:text-2xl xl:text-4xl 2xl:text-5xl">Ways to <span class="text-black">LIDO Earn</span>
            </h1>
            <p class="text-md xl:text-lg xl:max-2-4xl">
                Take a few minutes to help around the site or learn something thing.
                Earn Ada, Cardano Tokens and Nfts.
            </p>
        </div>
    </div>

    <div class="relative">
        <section class="border-t border-teal-300 p-6">
            <div class="max-w-2xl">
                <div class="flex flex-col gap-0">
                    <h2 class="font-bold leading-6 tracking-tight text-white mb-0 pb-0">
                        Kiswahili Jifunze upate tuzo
                    </h2>
                    <p class="text-slate-100">Lipwa kwa Kujifunza</p>
                </div>
                <a href="https://www.lidonation.com/sw/earn/learn"
                   class="inline-flex flex-col gap-4 btn bg-labs-red text-white rounded-sm px-3 py-1 my-4">
                    Earn
                </a>
            </div>
        </section>

        <section class="border-t border-teal-300 p-6 -my-1 ">
            <div class="max-w-2xl">
                <h2 class="font-bold leading-10 tracking-tight text-white mb-0 pb-0">
                    Every Epoch
                </h2>
                <p class="text-slate-100">
                    Learn, Play, & Win. Every 5 days!
                    <span
                        class="text-center inline-flex gap-1 text-xs md:text-base font-normal ml-1">
                                    <span>$PHUFFY</span>
                                    <span>$HOSKY</span>
                                    <span>$NMKR</span>
                                </span>
                </p>
                <a :href="$utils.localizeRoute('delegators') + '#everyEpoch'"
                   class="inline-flex flex-col gap-4 btn bg-white text-slate-800 rounded-sm px-3 py-1 my-4">
                    Earn
                </a>
            </div>
        </section>

        <section class="border-t border-teal-300 p-6 -my-1 ">
            <div class="max-w-3xl">
                <h2 class="font-bold leading-10 tracking-tight text-white mb-0 pb-0">
                    CCV4 - Catalyst Circle Voting
                </h2>
                <p class="text-slate-100">
                    If you voted during the election you can claim $hosky and $discoin per wallet.
                </p>
                <a href="#"
                   class="inline-flex items-center gap-2 btn bg-white text-slate-800 rounded-sm px-3 py-1 my-4">
                    Claim Tokens <span
                    class="text-xs bg-teal-600 text-white font-bold px-1 py-0 rounded-sm inline-flex">coming soon</span>
                </a>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import {computed, defineAsyncComponent, inject} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
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
