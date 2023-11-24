<template>
    <dl class="flex flex-col justify-between h-full text-white">
        <dd>
            <div class="text-4xl font-semibold lg:text-5xl">
                ₳{{ $filters.shortNumber(totalRegisteredAdaWithoutVotes, 3) }}           
            </div>
        </dd>
        <dt class="mt-3 text-xs xl:text-lg font-medium">
            ₳ registered but didn't vote
        </dt>
    </dl>
</template>

<script setup lang="ts">
import { ref,watch } from 'vue';
import { VARIABLES } from '../../../models/variables';
import axios from 'axios';

const props = defineProps<{
    fundId: number
}>()

let totalRegisteredAdaWithoutVotes = ref(null)

function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(route('catalyst-explorer.metrics.registeredAdaNotVoted'), { params })
        .then((res) => totalRegisteredAdaWithoutVotes.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();
</script>
