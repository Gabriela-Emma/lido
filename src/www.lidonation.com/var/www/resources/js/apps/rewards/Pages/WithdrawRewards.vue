<template v-if="!!withdrawals?.length || withdrawalsProcessed">
    <div
        class="container z-10 w-full h-full text-white bg-teal-600 shadow-lg">
        <div v-show="working"
             class="absolute top-0 left-0 z-20 flex items-start justify-center w-full h-full p-32 bg-teal-600 bg-opacity-90">
            <div
                class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                <svg
                    class="relative w-8 h-8 border-t-2 border-b-2 border-teal-600 rounded-full lg:w-16 lg:h-16 animate-spin"
                    viewBox="0 0 24 24"></svg>
            </div>
        </div>
        <div>
            <div class="relative px-4 py-5 sm:px-6" v-if="!withdrawalsProcessed">
                <h3 class="text-lg font-medium leading-6">
                    Process Rewards
                </h3>
                <div class="max-w-3xl mt-1 text-sm">
                    <p  v-if="adaReward < BigInt(2000000)">
                        You are about to withdraw pending rewards.
                        You will need to send 2 ada, and all pending rewards will be bundled
                        and sent to your wallet plus your 2 Ada minus tx fee.
                    </p>
                    <p v-else>
                        You are about to withdraw pending rewards.
                        Since you have more than 2 Ada in rewards you do not have to provide any min utxo.
                        All pending rewards will be bundled and sent to your wallet.
                    </p>
                </div>
                <div v-if="!withdrawing" class="mt-2 text-center">
                                                <span @click="withdrawalRewards"
                                                      class="inline-flex items-center px-1 py-1 text-sm text-teal-900 rounded-sm bg-accent-200 hover:bg-accent-400 hover:cursor-pointer">
                                                    Withdraw
                                                </span>
                </div>
                <span
                    class="absolute top-0 right-0 p-2 bg-teal-700 hover:cursor-pointer"
                    @click="withdrawals = []">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.5"
                                                     stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </span>
            </div>

            <div class="px-4 py-5 border-t border-teal-200 sm:p-0">
                <div class="flex flex-col items-center gap-8 pt-8"
                     v-if="withdrawalsProcessed">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor"
                         class="w-16 h-16 text-green-500">
                        <path fill-rule="evenodd"
                              d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                              clip-rule="evenodd"/>
                    </svg>

                    <p class="max-w-2xl px-8 my-2 text-lg">
                        Your withdrawal will be posted to
                        your wallet in about 12 to 24 hours.
                    </p>
                    <span> See <Link :href="route('rewards.withdrawals.index')">history and pending withdrawals</Link></span>
                </div>
                <dl class="overflow-y-auto" v-if="!withdrawalsProcessed && !!withdrawals?.length">
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
                                                            <span class="mr-3 text-xl font-semibold 2xl:text-2xl"
                                                                  v-text="$filters.shortNumber((withdrawal.amount / (withdrawal.asset_details?.divisibility > 0 ? withdrawal?.asset_details?.divisibility : 1)).toFixed(2))"></span>
                                <template
                                    v-if="withdrawal?.asset_details?.metadata?.logo">
                                                                <span
                                                                    class="relative inline-flex items-center w-4 ml-2 rounded-full 2xl:w-5 2xl:h-5">
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
<script setup lang="ts">
import route from "ziggy-js";
import {Link} from "@inertiajs/vue3";
import {computed, defineAsyncComponent, inject, Ref, ref} from "vue";
import RewardData = App.DataTransferObjects.RewardData;
import axios from "@/global/utils/axios";
import Wallet from "@apps/catalyst-explorer/models/wallet";
import {storeToRefs} from "pinia";
import {useWalletStore} from "@/global/stores/wallet-store";
const ConnectWallet = defineAsyncComponent(() => import('../../../global/Components/ConnectWallet.vue'));
const $utils: any = inject('$utils');

// wallet store
let walletStore = useWalletStore();
let {walletData} = storeToRefs(walletStore);

let myWallet: Ref<Wallet> = computed(() => walletData?.value);
let adaReward: Ref<BigInt> = computed(
    () => BigInt(100000000
        // rewards?.value?.filter((reward: RewardData) => reward.asset === 'lovelace')
        //     .reduce((acc, reward: RewardData) => acc + reward.amount, 0)
    )
);

const props = withDefaults(
    defineProps<{
        processedRewards?: RewardData[]
    }>(), {}
);

let working = ref(false);
let withdrawals: Ref<RewardData[]> = ref([]);
let paymentTx = ref(null);
let minterAddress = ref(null);
let withdrawing = ref(false);

let withdrawalsProcessed = computed(
    () => withdrawals?.value?.filter(
        (withdrawal: RewardData) => (withdrawal.status === 'processed' ||  withdrawal.status === 'validated')
    ).length > 0
);

let withdraw = async () => {
    working.value = true;
    try {
        withdrawals.value = (await axios.post(route('rewardsApi.withdrawals.index')))?.data;
    } catch (e) {
        console.error(e)
    }
    working.value = false;
}

let withdrawalRewards = async () => {
    working.value = true;
    withdrawing.value = true;
    const WalletService = ((await import('@/global/services/wallet-service')).default);
    try {
        // start processing withdrawal
        const processResponse = (await axios.post(route('rewardsApi.withdrawals.process'), {address: myWallet?.value?.address}));
        setTimeout(async () => {
            working.value = false;
            // @ts-ignore
            if (adaReward.value < BigInt(2000000)) {
                const walletService = new WalletService();
                await walletService.connectWallet(myWallet?.value?.name);
                minterAddress.value = (await axios.post(route('rewardsApi.withdrawals.mintAddress')))?.data;

                // get deposit
                const rawTx = await walletService.payToAddress(minterAddress?.value.address, {lovelace: BigInt(2000000)});
                const signedTx = await rawTx.sign().complete();
                paymentTx.value = await signedTx.submit();
            }

            // processing Withdrawal and send tx to backend
            const withdrawalResponse = (await axios.post(route('rewardsApi.withdrawals.withdraw'), {hash: paymentTx?.value}));
            withdrawals.value = withdrawalResponse?.data;
            working.value = false;
        }, 3000);
    } catch (e) {
        console.error(e);
    }
}
</script>
