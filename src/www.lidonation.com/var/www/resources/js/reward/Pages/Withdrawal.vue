<template>
    <div
        class="bg-gradient-to-br from-teal-500 via-teal-600 to-accent-900 relative text-white lido-rewards-wrapper min-h-[92vh]">
        <div class="container relative h-full">
            <div class="pb-8 border border-teal-300 border-t-0 col-span-6 xl:col-span-7">
                <div class="flex flex-row gap-3 justify-between p-5">
                    <div class="flex flex-col md:flex-row md:gap-2 md:items-center">
                        <h2 class="text-sm md:text-2xl xl:text-3xl">Withdrawal Detail</h2>
                    </div>
                    <div class="text-lg">
                        <RewardNav class="flex gap-3 text-white"></RewardNav>
                    </div>
                </div>
                <div class="relative">
                    <section class="border-t border-teal-300 p-6">
                        <div class="flex flex-col gap-4 bg-gray-800/20 rounded-sm">
                            <div class="flex w-full gap-8 lg:gap-12 p-4 lg:p-8 items-center">
                                <div class="flex gap-2 items-center">
                                    <div class="text-slate-200">Withdrawal Started</div>
                                    <div class="text-lg xl:text-xl">
                                        {{ createAt }}
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <div class="text-slate-200">
                                        Status
                                    </div>
                                    <div class="text-lg xl:text-xl">
                                        {{ withdrawal.status }}
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <RewardList :rewards="withdrawal.rewards"></RewardList>
                        </div>

                        <div class="p-4 lg:p-6 border-teal-300 mt-4">
                            <h3>Withdrawal Status Legend</h3>
                            <div class="flex gap-4 justify-around w-full ">
                                <div class="flex items-center gap-3">
                                    <div class="text-slate-300">pending</div>
                                    <div>withdrawal started, waiting for min utxo deposit</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-slate-300">processed</div>
                                    <div>Nothing to do. Your rewards will be sent shortly.</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-slate-300">paid</div>
                                    <div>Rewards should be in your wallet now.</div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import WithdrawalData = App.DataTransferObjects.WithdrawalData;
import RewardList from "../Components/RewardList.vue";
import {localTime} from "../../lib/utils/localTiime";
import {ref} from "vue";
import {timeAgo} from "../../lib/utils/timeago";
import RewardNav from "../Components/RewardNav.vue";

const props = defineProps<{
    withdrawal: WithdrawalData;
}>();

let createAt = ref(
    localTime(props.withdrawal.created_at)
);

</script>
