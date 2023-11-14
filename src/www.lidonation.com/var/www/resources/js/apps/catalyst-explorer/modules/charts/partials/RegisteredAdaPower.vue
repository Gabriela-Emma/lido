<template>
    <dl class="flex flex-col justify-between h-full text-center text-white">
        <dd>
            <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                ₳{{ $filters.shortNumber(totalRegisteredAdaPower, 3) }}
            </div>
        </dd>
        <dt class="mt-3 text-lg font-medium truncate">
            Total Registered Ada Voting Power
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

let totalRegisteredAdaPower = ref(null);


function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(route('catalyst-explorer.metrics.totalRegisteredAdaPower'), { params })
        .then((res) => totalRegisteredAdaPower.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();
</script>
