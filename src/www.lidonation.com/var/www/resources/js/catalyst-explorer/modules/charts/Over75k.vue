<template>
    <dl class="flex flex-col justify-between h-full">
        <dd>
            <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                {{ $filters.number(fundedOver75KCount) }}
            </div>
        </dd>
        <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
            Funded >= 75K
        </dt>
    </dl>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { VARIABLES } from '../../models/variables';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

const props = defineProps<{
    fundId: number
}>()

let fundedOver75KCount = ref(null);


function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(`${usePage().props.base_url}/catalyst-explorer/metrics/fundedOver75KCount`, { params })
        .then((res) => fundedOver75KCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();
</script>