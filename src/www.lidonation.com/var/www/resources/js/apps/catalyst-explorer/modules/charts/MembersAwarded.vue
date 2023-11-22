<template>
    <dl class="flex flex-col justify-between h-full">
        <dd>
            <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                {{ $filters.number(membersAwardedFundingCount) }}
            </div>
        </dd>
        <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
            Members Awarded Funding
        </dt>
    </dl>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { VARIABLES } from '../../models/variables';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import route from 'ziggy-js';

const props = defineProps<{
    fundId: number
}>()

let membersAwardedFundingCount = ref(null);


function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(route('catalyst-explorer.metrics.membersAwardedFundingCount'), { params })
        .then((res) => membersAwardedFundingCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();
</script>