<template>
    <table class="min-w-full overflow-auto divide-y divide-gray-200">
        <thead class="flex flex-col justify-between min-w-full">
        <tr class="flex flex-row text-left items-end">
            <th class="w-24 px-6 py-4 text-sm sticky top-0"># Rewards</th>
            <th class="w-72 px-6 py-4 text-sm sticky top-0">Date</th>
            <th class="px-2 w-40 py-4 text-sm truncate flex gap-2 sticky top-0">
                Status
            </th>
            <th class="px-6 w-80 py-4 text-sm truncate flex gap-2 sticky top-0">
                Deposit Tx
            </th>
            <th class="px-2 lg:px-6 py-4 text-sm truncate flex gap-2 sticky top-0 ml-auto">
                More Details
            </th>
        </tr>
        </thead>
        <tbody
            class="flex flex-col justify-start min-w-full divide-y divide-gray-400 max-h-[32rem]">
        <tr v-if="withdrawals?.length > 0" v-for="withdrawal in withdrawals"
            class="flex flex-row text-left">
            <td class="w-24 px-6 py-4 text-sm">
                {{ withdrawal.rewards.length }}
            </td>
            <td class="w-72 px-6 py-4 text-sm">
                {{ time(withdrawal.created_at) }}
            </td>
            <td class="px-2 py-4 text-sm truncate flex gap-2 w-40">
                {{ withdrawal.status }}
            </td>
            <td class="px-2 py-4 w-80 text-sm truncate flex gap-2 text-right">
                {{ withdrawal.txs[0]?.hash }}
            </td>
            <td class="px-2 lg:px-6 py-4 w-40 text-sm truncate flex gap-2 items-center ml-auto">
                <Link class="flex gap-2" :href="route('rewards.withdrawals.view', {withdrawal: withdrawal.id})">
                    <span>More Details</span>
                    <ArrowRightCircleIcon class="w-5 h-5"></ArrowRightCircleIcon>
                </Link>
            </td>
        </tr>
        <tr v-else class="flex flex-row text-left">
            <td class="px-6 py-4 text-sm font-medium">
                Nothing here yet.
            </td>
        </tr>
        </tbody>
    </table>
</template>
<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import WithdrawalData = App.DataTransferObjects.WithdrawalData;
import RewardList from "./RewardList.vue";
import {ArrowRightCircleIcon} from "@heroicons/vue/20/solid";
import {ref} from "vue";
import {localTime} from "../../lib/utils/localTiime";
import {timeAgo} from "../../lib/utils/timeago";

const props = withDefaults(
    defineProps<{
        withdrawals: WithdrawalData[],
    }>(), {}
);
let time = (time) => (localTime( time) );
</script>
