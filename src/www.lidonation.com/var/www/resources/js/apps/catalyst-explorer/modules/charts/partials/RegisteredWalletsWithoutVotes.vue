<template>
    <dl class="flex flex-col justify-between h-full">
        <dd>
            <div class="text-4xl font-semibold text-white lg:text-5xl" v-if="totalRegisteredWalletsWithoutVotes">
                {{ totalRegisteredWalletsWithoutVotes?.toLocaleString() }}
            </div>
            <div class="text-4xl font-semibold text-white lg:text-5xl" v-else>
                {{ '-' }}
            </div>
        </dd>
        <dt class="mt-3 text-xs xl:text-lg font-medium text-slate-200">
            Wallets registered but didn't vote
        </dt>
    </dl>
</template>

<script setup lang="ts">
import {  ref, watch } from 'vue';
import { VARIABLES } from '../../../models/variables';
import axios from 'axios';
import route from 'ziggy-js';


const props = defineProps<{
    fundId: number
}>()

let totalRegisteredWalletsWithoutVotes = ref(null)


function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    axios.get(route('catalyst-explorer.metrics.registeredWalletsNotVoted'), { params })
        .then((res) => totalRegisteredWalletsWithoutVotes.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

}

watch(() => props.fundId, () => {
    query();
})
query();
</script>
