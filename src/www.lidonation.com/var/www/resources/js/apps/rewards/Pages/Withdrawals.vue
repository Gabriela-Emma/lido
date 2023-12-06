<template>
    <div
        class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white lido-rewards-wrapper min-h-[92vh]">
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
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">Withdrawals</h2>
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
                    <section class="border-t border-teal-300 p-6 -my-1 ">
                        <div class="text-white bg-gray-900 bg-opacity-25 rounded-sm pb-2 relative">
                            <div class="rounded-tl-sm rounded-tr-md bg-teal-900 shadow-sm">
                                <div class="flex justify-between items-center px-4">
                                    <h3 class="py-2 font-semibold">
                                        <span>
                                            Withdrawals
                                        </span>
                                    </h3>
                                    <div class="flex flex-row gap-3">
                                        <RewardNav class="flex gap-3 text-white text-xs"></RewardNav>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div class="sm:px-6lg:px-8">
                                    <WithdrawalList :withdrawals="withdrawals"></WithdrawalList>
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
import {usePage} from '@inertiajs/vue3';
import {defineAsyncComponent, inject, ref, Ref} from 'vue';
import RewardNav from "../Components/RewardNav.vue";
import WithdrawalList from "../Components/WithdrawalList.vue";
import WithdrawalData = App.DataTransferObjects.WithdrawalData;
import PaginatedData from "@/global/interfaces/paginated-data";
import User from "@/global/models/user";

const ConnectWallet = defineAsyncComponent(() => import('../../../global/Components/ConnectWallet.vue'));
const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        withdrawalsPaginated: PaginatedData<WithdrawalData>
    }>(), {}
);
let withdrawals: Ref = ref(props?.withdrawalsPaginated?.data ?? []);
let user = ref(usePage()?.props?.user as User);

// withdraw
let working = ref(false);

</script>
