<template>
    <dl class="flex flex-col justify-between h-full">
        <dd>
            <div class="text-3xl font-semibold text-white lg:text-4xl 2xltext-5xl">
                ₳{{ $filters.shortNumber(totalDelegationRegistrationsAdaPower, 3) }}
            </div>
        </dd>
        <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
            ₳ Power delegated
        </dt>
    </dl>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { VARIABLES } from '../../../models/variables';
import axios from 'axios';
import route from 'ziggy-js';

const props = defineProps<{
    fundId: number
}>()

let totalDelegationRegistrationsAdaPower = ref(null);


function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(route('catalyst-explorer.metrics.totalDelegationRegistrationsAdaPower'), { params })
        .then((res) => totalDelegationRegistrationsAdaPower.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();
</script>
