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
                            <div class="flex flex-row">
                                 <span class="font-bold mr-2 mt-2 px-4">Total Rewards:</span>
                                 <div v-for="groupedAsset in resultArray" :key="groupedAsset?.asset" class="flex flex-column justify-between p-2">
                                 <div class="font-bold mr-2">{{ (groupedAsset?.asset === 'lovelace') ? 'Ada' : groupedAsset?.asset}}</div>
                                 <div>{{ $filters.shortNumber((groupedAsset?.amount/ groupedAsset?.divisibility).toFixed(2))}}</div>
                                </div>
                            </div>
                        <div class="flex w-full gap-8 lg:gap-12 p-4 lg:p-8 items-center">
                                <div class="flex gap-2 items-center">
                                    <div class="text-slate-200 text-sm">Withdrawal Started</div>
                                    <div class="text-md xl:text-lg">
                                        {{ createAt }}
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <div class="text-slate-200 text-sm">
                                        Status
                                    </div>
                                    <div class="text-md xl:text-lg">
                                        {{ withdrawal.status }}
                                    </div>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <div class=" text-sm"></div>
                                    <div class="text-md xl:text-lg"></div>
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
import {Ref, ref} from "vue";
import {timeAgo} from "../../lib/utils/timeago";
import RewardNav from "../Components/RewardNav.vue";
import GroupedAsset from "../models/grouped-asset";

const props = defineProps<{
    withdrawal: WithdrawalData;
}>();

let rewards = ref(
    props.withdrawal.rewards
)

const groupedAsset = rewards.value.reduce((result, obj) => {
const asset = obj?.asset;
  if (!result[asset]) {
    result[asset] = { asset, amount: 0 };
  }
  result[asset].amount += obj?.amount
  result[asset].divisibility = obj?.asset_details?.divisibility;
  return result;
}, {} );

const resultArray = Object.values(groupedAsset as GroupedAsset[]);
let createAt = ref(
    localTime(props.withdrawal.created_at)
);

</script>
