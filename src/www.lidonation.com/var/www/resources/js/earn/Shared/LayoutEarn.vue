<template>
    <header>
        <EarnNav :crumbs="crumbs"/>
    </header>

    <main
        class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white catalyst-proposals-bookmarks-wrapper min-h-[92vh]">
        <div class="container relative h-full">
            <div class="pb-8 border border-teal-300 border-t-0">
                <slot></slot>
            </div>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {router, useForm, usePage} from '@inertiajs/vue3';
import {computed, defineAsyncComponent, inject, ref, Ref} from 'vue';
import User from '../../global/Shared/Models/user';
import {useWalletStore} from '../../catalyst-explorer/stores/wallet-store';
import Wallet from '../../catalyst-explorer/models/wallet';
import {storeToRefs} from 'pinia';
import RewardData = App.DataTransferObjects.RewardData
import {AxiosError} from 'axios';
import EarnNav from "../modules/earn/components/EarnNav.vue";

const ConnectWallet = defineAsyncComponent(() => import('../../global/Shared/Components/ConnectWallet.vue'));
const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {}
);

let user = ref(usePage()?.props?.user as User);

// wallet store
let walletStore = useWalletStore();
let {walletData} = storeToRefs(walletStore);
let myWallet: Ref<Wallet> = computed(() => walletData?.value);

//wallet login error
let walletError = ref(null);
let handleWalletError = (error) => {
    walletError.value = error.message;
}

//get loggedin user
let setUser = (userData) => {
    refresh();
}

// refetch pagedata
function refresh() {
    router.get(`${usePage().props.base_url}/rewards/`);
}

// login with email
let form = useForm({})
let errors = ref('');
let getForm = (loginForm) => {
    form = loginForm
}
let submit = async (event) => {
    try {
        const res = await window.axios.post(`/api/rewards/login`, form);
        if (res) {
            refresh();
        }
    } catch (e: AxiosError | any) {
        console.error({e});
        errors.value = e?.response?.data?.message
    }
}

// withdraw
let working = ref(false)
let withdrawals: Ref<RewardData[]> = ref(null)
let withdraw = async () => {
    working.value = true;
    try {
        withdrawals.value = (await window.axios.post(`/api/rewards/withdrawals`))?.data;

    } catch (e) {
        console.error(e)
    }
    working.value = false;
}

//withdrawal-rewards
let withdrawalsProcessed = ref(null);
let paymentTx = ref(null);
let minterAddress = ref(null);

</script>
