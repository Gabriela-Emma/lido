<template>
    <div class="flex flex-row flex-wrap gap-y-3 gap-x-6">
        <div class="flex items-center gap-2">
            <div class="text-sm text-slate-500 xl:text-base">Total Blocks</div>
            <div class="text-base font-bold xl:text-xl" v-text="poolDetails?.blocks_minted ?? '-'"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="text-sm text-slate-500 xl:text-base">Blocks in Epoch</div>
            <div class="text-base font-bold xl:text-xl" v-text="poolDetails?.blocks_epoch ?? '-'"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="text-sm text-slate-500 xl:text-base">Live Stake</div>
            <div class="text-base font-bold xl:text-xl" v-text="poolDetails?.live_stake ? $filters.shortNumber(poolDetails.live_stake/1000000) + ' ₳' :  '-'"></div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import {useDelegatorsStore} from '../../stores/delegators-store';
import {storeToRefs} from "pinia";

let delegatorsStore = useDelegatorsStore();
let {poolDetails} = storeToRefs(delegatorsStore);
</script>