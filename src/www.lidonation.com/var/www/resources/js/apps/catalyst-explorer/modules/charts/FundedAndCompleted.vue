<template>
    <div>
        <dl class="flex flex-col justify-between">
            <dd>
                <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                    {{ fullyDisbursedProposalsCount }}
                </div>
            </dd>
            <dt class="mt-3 text-xs font-medium text-gray-200 truncate 2xl:text-lg">
                Total Funded Proposals
            </dt>
        </dl>
    </div>

    <div class="ml-auto md:mt-auto">
        <dl class="flex flex-col justify-between text-right">
            <dd>
                <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                    {{ $filters.number(completedProposalsCount) }}
                </div>
            </dd>
            <dt class="mt-3 text-xs font-medium text-gray-200 truncate 2xl:text-lg">
                Completed Proposals
            </dt>
        </dl>
    </div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, ref } from 'vue';
import { VARIABLES } from '../../models/variables';
import { watch } from 'vue';
import route from 'ziggy-js';

const props = defineProps<{
    fundId: number
}>()

let fullyDisbursedProposalsCount = ref(null);
let completedProposalsCount = ref(null);
let fundId = ref(props.fundId);


function getQueryData() {
    const data = {};
    if (fundId.value) {
        data[VARIABLES.FUNDS] = fundId.value;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(route('catalyst-explorer.metrics.fullyDisbursedProposalsCount'), { params })
        .then((res) => fullyDisbursedProposalsCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    axios.get(route('catalyst-explorer.metrics.completedProposalsCount'), { params })
        .then((res) => completedProposalsCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();

</script>
