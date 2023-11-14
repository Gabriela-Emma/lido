<template>
    <section class="relative mt-12 mb-12 border-t border-slate-200 ">
        <div class="">
            <div class=" text-white bg-teal-800 rounded-sm min-h-[652px]">
                <Spinner :fillColor="'fill-teal-600'" />
                <div class="py-4 text-center border-b border-teal-900 xl:mb-8">
                    <h2 class="p-4 mx-auto text-center font-display xl:text-4xl">
                        {{ epochDetails?.title }}
                    </h2>
                    <div class="flex flex-row flex-wrap items-center justify-center gap-8 px-8 xl:justify-start xl:gap-4">

                        <div class="text-green-500">
                            <div v-if="rewardPot"
                                class="w-full mb-2 text-xs font-semibold -rotate-45relative -left-24-bottom-1 xl:text-left">
                                Available in Prizes for completing successfully.
                            </div>

                            <RewardPot />
                        </div>

                        <div class="max-w-xl px-4 mx-auto text-lg font-normal text-center">
                            <!-- <div v-html="everyEpoch.content"></div> -->
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">
                    <div class="flex flex-col justify-center">
                        <div class="p-8 py-10 bg-teal-900 rounded-sm min-h-[532px]">
                            <div v-if="epochDetails?.epoch == '168'">
                                <!-- <DelegatorNft></DelegatorNft> -->
                            </div>
                            <div v-else>
                                <div>
                                    <div class="flex flex-col items-center justify-center"
                                        v-if="quiz && isConnected == false && questionForm && !walletData?.stakeAddress">
                                        <h2>
                                            Let's get you connected!
                                        </h2>
                                        <ConnectWallet />
                                    </div>
                                    <div v-show="quiz && walletData?.stakeAddress && answerResponse"
                                        class="flex flex-col items-center justify-center gap-4">
                                        <LidoEpochRewards>
                                            <div v-if="!claimed && !processing">
                                                <ClaimRewards @claim-asset="makeClaim($event)" />
                                            </div>
                                            <div v-if="!claimed && epochErrors && !processing">
                                                <span class="mb-4 text-xl font-semibold text-center text-pink-600">{{
                                                    epochErrors }}</span>
                                            </div>
                                            <div v-if="processing" type="button"
                                                class="flex flex-col items-center justify-center text-xl text-bold">
                                                <svg aria-hidden="true" role="status"
                                                    class="inline w-4 h-4 mr-3 text-gray-200 animate-spin dark:text-gray-600"
                                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                        fill="#1C64F2" />
                                                </svg>
                                                processing claim...
                                            </div>
                                            <div v-if="claimed && !processing"
                                                class="flex flex-col items-center justify-center text-bold">
                                                <span class="mb-4 text-xl font-semibold text-center">Reward has been
                                                    claimed</span>
                                                <span>
                                                    <a :href="route('rewards.index')" type="button"
                                                        class="inline-flex items-center gap-2 rounded-sm border border-green-500 bg-transparent px-2 py-1.5 text-xl font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V19.5z" />
                                                        </svg>
                                                        <span>See Rewards</span>
                                                    </a>
                                                </span>
                                            </div>
                                        </LidoEpochRewards>
                                    </div>
                                </div>
                                <EveryEpochQuiz v-if="!questionForm" @questionForm="submit($event)" />
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="px-8 xl:px-8 2xl:px-16">
                            <div class="px-4 py-4 mb-8 border-4 border-teal-900 rounded-sm xl:px-8 2xl:px-16">
                                <div class="mb-2 text-xs text-center">
                                    {{ epochDetails?.title }} is brought to you by
                                    <a :href="partnerPromo?.uri" class="font-semibold" target="_blank">
                                        {{ partnerPromo?.title }}
                                    </a>
                                </div>
                                <div class="relative rounded-sm">
                                    <Promo :customise="true"
                                            @promo-data="setPromo($event)"
                                            :background-color="''"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <svg aria-hidden="true" width="0" height="0">
                    <defs>
                        <clipPath id=":R9m:-0" clipPathUnits="objectBoundingBox">
                            <path
                                d="M0,0 h0.729 v0.129 h0.121 l-0.016,0.032 C0.815,0.198,0.843,0.243,0.885,0.243 H1 v0.757 H0.271 v-0.086 l-0.121,0.057 v-0.214 c0,-0.032,-0.026,-0.057,-0.057,-0.057 H0 V0">
                            </path>
                        </clipPath>
                        <clipPath id=":R9m:-1" clipPathUnits="objectBoundingBox">
                            <path
                                d="M1,1 H0.271 v-0.129 H0.15 l0.016,-0.032 C0.185,0.802,0.157,0.757,0.115,0.757 H0 V0 h0.729 v0.086 l0.121,-0.057 v0.214 c0,0.032,0.026,0.057,0.057,0.057 h0.093 v0.7">
                            </path>
                        </clipPath>
                        <clipPath id=":R9m:-2" clipPathUnits="objectBoundingBox">
                            <path
                                d="M1,0 H0.271 v0.129 H0.15 l0.016,0.032 C0.185,0.198,0.157,0.243,0.115,0.243 H0 v0.757 h0.729 v-0.086 l0.121,0.057 v-0.214 c0,-0.032,0.026,-0.057,0.057,-0.057 h0.093 V0">
                            </path>
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { usePage } from '@inertiajs/vue3';
import { computed, defineAsyncComponent, ref, watch, inject } from 'vue';
import { useWalletStore } from '@/global/stores/wallet-store';
import ClaimRewards from './ClaimRewards.vue';
import LidoEpochRewards from './LidoEpochRewards.vue';
import Promo from '@/global/Components/Promo.vue';
import Spinner from '@/global/Components/Spinner.vue';
import route from "ziggy-js";
import {useEveryEpochStore} from "@apps/delegators/stores/every-epoch-store";
import {useSpinnerStore} from "@/global/stores/spinner-store";
import EveryEpochQuiz from "@apps/delegators/modules/everyEpoch/EveryEpochQuiz.vue";
import User from '@/global/models/user';
const RewardPot = defineAsyncComponent(() => import('@apps/delegators/modules/everyEpoch/RewardPot.vue'));
const ConnectWallet = defineAsyncComponent(() => import('@/global/Components/ConnectWallet.vue'));



const $utils: any = inject('$utils');
const user = computed(() => usePage().props.user as User)
const walletStore = useWalletStore();
const { walletData } = storeToRefs(walletStore);

const epochStore = useEveryEpochStore();
const spinnerStore = useSpinnerStore();
const { answerResponse } = storeToRefs(epochStore);
const { epochDetails } = storeToRefs(epochStore);
const { rewardPot } = storeToRefs(epochStore)
const { claimed } = storeToRefs(epochStore);
const { quiz } = storeToRefs(epochStore);
const { loaded } = storeToRefs(epochStore);
const { processing } = storeToRefs(epochStore);
const { epochErrors } = storeToRefs(epochStore);
let isConnected = computed(() => walletData.value != null)
let partnerPromo = ref(null);
let setPromo = (promo) => {
    partnerPromo.value = promo;
}

watch(loaded, () => {
    if (loaded) {
        spinnerStore.stopSpinner();
    }
})

let questionForm = ref(null);
let submit = (form) => {
    questionForm.value = form;
    if (!form?.stake_address) {
        watch([isConnected], () => {
            if (questionForm.value) {
                questionForm.value.stake_address = walletData.value?.stakeAddress
                questionForm.value.wallet_address = walletData.value?.address
                submit(questionForm.value)
            }
        }, { deep: true })
    }

    if (form?.stake_address && isConnected) {
        epochStore.submitAnswer(form);
    }
}

let makeClaim = (asset) => {
    epochStore.claimAsset(asset)
}


</script>
