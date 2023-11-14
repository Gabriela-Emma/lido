<template>
    <table class="min-w-full overflow-auto divide-y divide-gray-200">
        <thead class="flex flex-col justify-between min-w-full">
        <tr class="flex flex-row text-left">
            <th class="px-6 w-40 py-4 text-sm truncate flex gap-2 sticky top-0">
                Amount
            </th>
            <th class="w-72 px-6 py-4 text-sm sticky top-0">Memo</th>
            <th class="px-2 py-4 text-sm truncate flex gap-2 sticky top-0">
                Status
            </th>
        </tr>
        </thead>
        <tbody
            class="flex flex-col justify-start min-w-full divide-y divide-gray-400 max-h-[32rem] overflow-y-auto">
            <tr v-if="rewards?.length > 0" v-for="reward in rewards"
                class="flex flex-row text-left">
                <td class="px-6 py-4 w-40 text-sm truncate flex gap-2  items-center">
                     <span
                         class="font-semibold text-xl 2xl:text-2xl">
                         {{
                             $filters.shortNumber((reward.amount / (reward.asset_details?.divisibility > 0 ? reward?.asset_details?.divisibility : 1)).toFixed(2))
                         }}
                    </span>
                    <span v-if="reward.asset_details?.metadata?.logo"
                          class="relative inline-flex flex-shrink-0 items-center rounded-full 2xl:w-5 w-4 2xl:h-5">
                        <img class="inline-flex"
                             alt="asset logo"
                             :src="'data:image/png;base64,'+`${reward.asset_details.metadata.logo}`">
                    </span>
                    <span
                        v-else-if="reward?.asset_details?.metadata?.ticker"
                        class="relative inline-block rounded-full w-3 h-3">
                        {{reward.asset_details?.metadata?.ticker }}
                    </span>
                    <span v-else class="relative inline-block rounded-full w-3 h-3">
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
            <tr v-else class="flex flex-row text-left">
                <td class="px-6 py-4 text-sm font-medium">
                    No New Rewards. See <Link :href="route('rewards.withdrawals.index')">history and pending withdrawals</Link>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script lang="ts" setup>
import RewardData = App.DataTransferObjects.RewardData;
import {Link} from "@inertiajs/vue3";

const props = withDefaults(
    defineProps<{
        rewards: RewardData[],
    }>(), {}
);
</script>
