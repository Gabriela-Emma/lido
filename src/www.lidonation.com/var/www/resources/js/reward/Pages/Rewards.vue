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

            <div class="mb-8 border border-teal-300 border-t-0 col-span-6 xl:col-span-7">
                <div class="flex flex-row gap-3 justify-between p-5">
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">My Lido Rewards</h2>
                    </div>
                </div>
                <div class="relative">
                    <section class="border-t border-teal-300 p-6">
                        <div class="flex flex-col gap-4 items-center max-w-2xl mx-auto">
                            <p>
                                Lido Rewards are tips and prizes you earn around lidonation for completing
                                challenges or
                                contributing to the site, or delegating to the stake pool.
                                They are typically in the form of cardano native tokens (ie: $hosky, $nmkr,
                                $discoin,
                                etc). They can also be NFTs!
                            </p>
                            <p>All your rewards shows up here for accounting and withdrawal!</p>
                            <p>Happy earning!</p>
                        </div>
                    </section>
                    <section class="border-t border-teal-300 p-6 -my-1 ">
                        <template v-if="user != null">
                            <template v-if="withdrawals">
                                <div
                                    class="absolute left-0 top-0 w-full h-full bg-teal-600 shadow-lg z-10 text-white">
                                    <div>
                                        <div class="px-4 py-5 sm:px-6 relative" v-show="!withdrawalsProcessed">
                                            <h3 class="text-lg font-medium leading-6">
                                                Process Rewards
                                            </h3>
                                            <p class="mt-1 max-w-3xl text-sm">
                                                You are about to withdraw pending rewards.
                                                You will need to send 2 ada, and all pending rewards will be bundled
                                                and sent to your
                                                wallet plus your 2 Ada minus tx fee.

                                            </p>
                                            <div v-show="rewards" class="mt-2 text-center">
                                                <span @click="withdrawalRewards"
                                                      class="inline-flex items-center px-1 py-1 rounded-sm text-sm bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">
                                                    Withdraw
                                                </span>
                                            </div>
                                            <span
                                                class="absolute right-0 top-0 p-2 bg-teal-700 hover:cursor-pointer"
                                                @click="withdrawals = null">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.5"
                                                     stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </span>
                                        </div>

                                        <div class="border-t border-teal-200 px-4 py-5 sm:p-0">
                                            <div class="flex flex-col items-center gap-8 pt-8"
                                                 v-show="withdrawalsProcessed">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     fill="currentColor"
                                                     class="w-16 h-16 text-green-500">
                                                    <path fill-rule="evenodd"
                                                          d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                          clip-rule="evenodd"/>
                                                </svg>

                                                <p class="my-2 max-w-2xl text-lg px-8">
                                                    Your withdrawal will be posted to
                                                    your wallet in about 5 to 10 minutes.
                                                </p>
                                            </div>
                                            <dl class="overflow-y-auto" v-show="!withdrawalsProcessed">
                                                <template v-for="(withdrawal, index) in withdrawals"
                                                          :key="withdrawal?.asset">
                                                    <div
                                                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                                                        :class="{'bg-teal-700': index % 2 === 0}">
                                                        <dt class="text-sm font-medium">
                                                            <span class="flex gap-2">
                                                                <span
                                                                    v-text="withdrawal?.asset_details?.asset_name"></span>
                                                            </span>
                                                        </dt>
                                                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                                            <span class="font-semibold text-xl 2xl:text-2xl mr-3"
                                                                  v-text="$filters.shortNumber((withdrawal.amount / (withdrawal.asset_details?.divisibility > 0 ? withdrawal?.asset_details?.divisibility : 1)).toFixed(2))"></span>
                                                            <template
                                                                v-if="withdrawal?.asset_details?.metadata?.logo">
                                                                <span
                                                                    class="relative inline-flex items-center rounded-full 2xl:w-5 w-4 2xl:h-5 ml-2">
                                                                    <img class="inline-flex"
                                                                         :src="'data:image/png;base64,'+`${withdrawal?.asset_details?.metadata?.logo}`"
                                                                         :alt="`${withdrawal?.asset_details?.asset_name}`"/>
                                                                </span>
                                                            </template>
                                                        </dd>
                                                    </div>
                                                </template>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </template>


                            <div class="text-white bg-gray-900 bg-opacity-25 rounded-sm pb-2 relative">
                                <div class="rounded-tl-sm rounded-tr-md bg-teal-900 shadow-sm">
                                    <div class="flex justify-between items-center px-4">
                                        <h3 class="py-2 font-semibold">
                                                <span>
                                                    Rewards
                                                </span>
                                            <span class="text-xs text-gray-400">
                                                    {{ rewards.length }}
                                                </span>
                                        </h3>
                                        <div>
                                                <span v-show="rewards[0]" @click="withdraw"
                                                      class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">
                                                    Withdraw
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex flex-col">
                                        <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                <table class="min-w-full overflow-auto divide-y divide-gray-200">
                                                    <thead class="flex flex-col justify-between min-w-full">
                                                    <tr class="flex flex-row text-left">
                                                        <th class="px-6 w-32 py-4 text-sm truncate flex gap-2 sticky top-0">
                                                            Amount
                                                        </th>
                                                        <th class="w-72 px-6 py-4 text-sm sticky top-0">Memo</th>
                                                        <th class="px-2 py-4 text-sm truncate flex gap-2 sticky top-0">Status
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody
                                                        class="flex flex-col justify-start min-w-full divide-y divide-gray-400 max-h-[32rem]">
                                                    <tr v-for="reward in (rewards[0] ? rewards : processedRewards)"
                                                        class="flex flex-row text-left">
                                                        <td class="px-6 py-4 w-32 text-sm truncate flex gap-2  items-center">
                                                                         <span
                                                                             class="font-semibold text-xl 2xl:text-2xl">
                                                                             {{
                                                                                 $filters.shortNumber((reward.amount / (reward.asset_details?.divisibility > 0 ? reward?.asset_details?.divisibility : 1)).toFixed(2))
                                                                             }}
                                                                        </span>
                                                            <span v-if="reward.asset_details?.metadata?.logo"
                                                                  class="relative inline-flex items-center rounded-full 2xl:w-5 w-4 2xl:h-5">
                                                                                <img class="inline-flex"
                                                                                     alt="asset logo"
                                                                                     :src="'data:image/png;base64,'+`${reward.asset_details.metadata.logo}`">
                                                                            </span>
                                                            <span
                                                                v-else-if="reward?.asset_details?.metadata?.ticker"
                                                                class="relative inline-block rounded-full w-3 h-3">
                                                                                 {{
                                                                    reward.asset_details?.metadata?.ticker
                                                                }}
                                                                            </span>
                                                            <span v-else="reward?.asset_details?.asset_name"
                                                                  class="relative inline-block rounded-full w-3 h-3">
                                                                                {{ reward.asset_details?.asset_name }}
                                                                            </span>
                                                        </td>
                                                        <td class="w-72 px-6 py-4 text-sm">
                                                            {{ reward.memo }}
                                                        </td>
                                                        <td class="px-2 py-4 text-sm truncate flex gap-2">
                                                            {{ reward.status }}
                                                        </td>
                                                    </tr>
                                                    <tr v-show="!rewards[0] && !processedRewards[0]"
                                                        class="flex flex-row text-left">
                                                        <td class="px-6 py-4 text-sm font-medium">
                                                            Nothing to see quit yet.
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="flex justify-center" v-show="!rewards">
                            <div class="mt-2 flex flex-col gap-6 bg-white/[.92] py-5 px-8">
                                <div v-show="walletError.length>0" v-text="walletError"
                                     class="text-red-500 w-96 text-sm my-1"></div>
                                <WalletLoginBtnVue role="reward"
                                                   redirect="rewards"
                                                   @walletError="handleWalletError($event)"
                                                   @walletLoginSuccessful="refresh"
                                                   @user="setUser($event)"/>
                                <div>
                                    <Divider />
                                </div>

                                <div class="text-slate-800">
                                    <LoginForm :forRewards="true"
                                               :embedded="true"
                                               :showLogo="false"
                                               :showDivider="false"
                                               :showWalletBtn="false"
                                               :role="'rewards'"
                                               @setForm="getForm($event)"
                                               @submit="submit($event)"/>
                                    <div v-show="errors.length>0" v-text="errors"
                                         class="text-red-500 w-96 text-sm my-1"></div>
                                </div>
                            </div>
                        </div>

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
let walletError = ref('');
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
