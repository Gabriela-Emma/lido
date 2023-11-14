<template>
    <div class="flex flex-row items-center justify-center w-full gap-3 xl:justify-start">
        <div v-for="asset in rewardPot">
            <a v-if="asset['amount'] >= rewardTemplate?.[asset['asset'] + '.amount']"
                :href="'https://cexplorer.io/' + `${asset['name']}`" target="_blank">
                <div class="p-4 border border-green-500">
                    <div class="text-xl font-semibold xl:text-3xl 2xl:text-5xl">
                        {{ $filters.shortNumber(asset['amount'] / asset['divisibility']) }}
                    </div>
                    <div class="text-sm text-green-600">
                        ${{ asset['name'] }}
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useEveryEpochStore } from '../../stores/every-epoch-store';
import { storeToRefs } from 'pinia';

const epochStore = useEveryEpochStore();
const { rewardPot } = storeToRefs(epochStore)
const { rewardTemplate } = storeToRefs(epochStore)

</script>