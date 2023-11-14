<template>
    <div class="flex justify-center w-full gap-2 p-2">
        <div v-for="asset in rewardPot">
            <button v-if="asset['amount'] >= rewardTemplate?.[asset['asset'] + '.amount']" type="button"
                @click.prevent="claimReward(asset['asset'])"
                class="inline-flex items-center rounded-sm border border-green-500 bg-transparent px-2.5 py-1.5 text-md font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Claim {{ rewardTemplate?.[asset['asset'] + '.amount'] ? $filters.shortNumber(rewardTemplate[asset['asset'] +
                    '.amount'] / asset['divisibility'], 2) : '-' }}
                ${{ asset['name'] }}
            </button>
            <div v-else>
                <h2>
                    Looks like available rewards in selected asset have all been issued. Come back next epoch
                </h2>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useEveryEpochStore } from '../../stores/every-epoch-store';

const epochStore = useEveryEpochStore();
const { rewardPot } = storeToRefs(epochStore)
const { rewardTemplate } = storeToRefs(epochStore)


const emit = defineEmits<{
    (e: 'claimAsset', asset): void,
}>();
let claimReward = (asset) => {
    emit('claimAsset',asset)
}


</script>