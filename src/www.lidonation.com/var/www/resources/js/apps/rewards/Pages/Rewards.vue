<template>
    <div
        class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white lido-rewards-wrapper min-h-[92vh]">
        <div class="container relative h-full">
            <div class="col-span-6 pb-8 border border-t-0 border-teal-300 xl:col-span-7">
                <div class="flex flex-row justify-between gap-3 p-5">
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">My Lido Rewards</h2>
                    </div>
                    <div>
                        <ConnectWallet />
                    </div>
                </div>
                <div class="relative">
                    <section class="p-6 border-t border-teal-300">
                        <div class="flex flex-col justify-start max-w-4xl gap-2">
                            <p>
                                Lido Rewards are tips and prizes you earn around lidonation for completing
                                challenges or contributing to the site, or delegating to the stake pool.
                                They are typically in the form of cardano native tokens
                                (ie: $hosky, $discoin, etc). They can also be NFTs!
                            </p>
                            <p>All your rewards shows up here for accounting and withdrawal!</p>
                        </div>
                    </section>

                    <section class="p-6 -my-1 border-t border-teal-300 ">
                        <div class="relative pb-2 text-white bg-gray-900 bg-opacity-25 rounded-sm">
                            <div class="bg-teal-900 rounded-tl-sm shadow-sm rounded-tr-md">
                                <div class="flex items-center justify-between px-4">
                                    <h3 class="py-2 font-semibold">
                                        <span>
                                            Rewards
                                        </span>
                                        <span class="text-xs text-gray-400">
<!--                                                {{ rewards.length }}-->
                                        </span>
                                    </h3>
                                    <div class="flex flex-row gap-3">
                                        <RewardNav class="flex gap-3 text-xs text-white"></RewardNav>
                                        <button v-if="rewards[0]" @click="withdraw"
                                              class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-accent-200 text-teal-900 hover:bg-accent-400 hover:cursor-pointer">
                                            Withdraw
                                        </button>
                                        <button v-else
                                              class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-slate-500">
                                            No New Rewards
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex flex-col">
                                    <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                           <RewardList :rewards="rewards ?? []"></RewardList>
                                        </div>
                                    </div>
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
import {useForm, usePage} from '@inertiajs/vue3';
import {defineAsyncComponent, inject, ref, Ref} from 'vue';
import {storeToRefs} from 'pinia';
import RewardData = App.DataTransferObjects.RewardData
import RewardNav from "../Components/RewardNav.vue";
import RewardList from "../Components/RewardList.vue";
import {useWalletStore} from "@/global/stores/wallet-store";
import User from "@/global/models/user";
import axios from "@/global/utils/axios";

const ConnectWallet = defineAsyncComponent(() => import('../../../global/Components/ConnectWallet.vue'));
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
let rewards = ref(props?.rewards?.data ?? []);

// wallet store
let walletStore = useWalletStore();
let {walletData} = storeToRefs(walletStore);

// re-fetch page data

// login with email
let form = useForm({})
let errors = ref('');

</script>
