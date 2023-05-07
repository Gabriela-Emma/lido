<template>
    <div
        class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white catalyst-proposals-bookmarks-wrapper min-h-[92vh]">
        <div class="container relative h-full">
            <div v-show="working"
                 class="left-0 top-0 flex items-start justify-center w-full h-full p-32 absolute bg-teal-600 bg-opacity-90 z-20">
                <div
                    class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                    <svg
                        class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"
                        viewBox="0 0 24 24"></svg>
                </div>
            </div>

            <div class="pb-8 border border-teal-300 border-t-0 col-span-6 xl:col-span-7">
                <div class="flex flex-row gap-3 justify-between p-5">
                    <div class="flex flex-col md:flex-rowmd:gap-2md:items-end">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">LIDO Earn</h2>
                        <p>
                            Take a few minutes to help around the site or learn something thing. Earn Ada, Cardano Tokens and Nfts
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <section class="border-t border-teal-300 p-6">
                        <div class="flex flex-col gap-4 items-center max-w-2xl mx-auto">
                        </div>
                    </section>
                    <section class="border-t border-teal-300 p-6 -my-1 ">


                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {router, useForm, usePage} from '@inertiajs/vue3';
import {computed, defineAsyncComponent, inject, ref, Ref} from 'vue';
import User from '../../global/Shared/Models/user';
import WalletLoginBtnVue from '../../global/Shared/Components/WalletLoginBtn.vue';
import Divider from '../../global/Shared/Components/Divider.vue';
import LoginForm from '../../global/Shared/Components/LoginForm.vue'
import {useWalletStore} from '../../catalyst-explorer/stores/wallet-store';
import Wallet from '../../catalyst-explorer/models/wallet';
import {storeToRefs} from 'pinia';
import RewardData = App.DataTransferObjects.RewardData
import {AxiosError} from 'axios';

const ConnectWallet = defineAsyncComponent(() => import('../../global/Shared/Components/ConnectWallet.vue'));
const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        rewards?: {
            links?: [],
            total?: number,
            to?: number,
            from?: number,
            data?: RewardData[]
        };
        processedRewards?: RewardData[]
    }>(), {}
);


let user = ref(usePage()?.props?.user as User);
let rewards = ref(props?.rewards?.data);

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
let withdrawalRewards = async () => {
    working.value = true;
    const WalletService = ((await import('../../lib/services/WalletService')).default);
    try {
        // start processing withdrawal
        const processResponse = (await window.axios.post(`/api/rewards/withdrawals/process`, {address: myWallet?.value?.address}));
        setTimeout(async () => {
            console.log({processResponse});

            const walletService = new WalletService();
            await walletService.connectWallet(myWallet?.value?.name);
            minterAddress.value = (await window.axios.post(`/api/rewards/withdrawals/address`))?.data;

            // get deposit
            const rawTx = await walletService.payToAddress(minterAddress?.value.address, {lovelace: BigInt(2000000)});
            const signedTx = await rawTx.sign().complete();
            paymentTx.value = await signedTx.submit();

            // processing Withdrawal and send tx to backend
            const withdrawalResponse = (await window.axios.post(`/api/rewards/withdrawals/withdraw`, {hash: paymentTx.value}));
            withdrawalsProcessed = withdrawalResponse?.data;
            working.value = false;
        }, 3000);
    } catch (e) {
        console.error(e);
    }
}

</script>
