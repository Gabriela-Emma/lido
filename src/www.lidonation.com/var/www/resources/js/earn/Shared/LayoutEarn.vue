<template>
    <header>
        <EarnNav :crumbs="crumbs" />
    </header>

    <main
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

            <div class="pb-8 border border-teal-300 border-t-0">
                <div class="flex flex-row gap-3 justify-between p-5">
                    <div class="flex flex-col md:flex-rowmd:gap-2md:items-end">
                        <h1 class="text-md md:text-2xl xl:text-4xl 2xl:text-5xl">Ways to <span class="text-black">LIDO Earn</span></h1>
                        <p class="text-md xl:text-lg xl:max-2-4xl">
                            Take a few minutes to help around the site or learn something.
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
                                Learn + Earn. Every 5 days!
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
                </div>
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
