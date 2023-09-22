<template>
    <div class="grid grid-cols-7 gap-4">
        <div class="col-span-2 p-2 bg-white text-teal-900">
            <dl class="flex flex-col justify-between p-2">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                        {{ $filters.shortNumber(yesVotesSum, 2) }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate">
                    Yes Votes ₳ Sum
                </dt>
            </dl>
        </div>

        <div class="col-span-3 bg-teal-900 p-2">
            <dl class="flex flex-col justify-between">
                <dd>
                    <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                        {{ $filters.number(talliesSum$, 2) }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                    Total Votes Cast
                </dt>
            </dl>
        </div>

        <div class="col-span-2 p-2 bg-white text-teal-900">
            <dl class="flex flex-col justify-between text-right">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                        {{ $filters.shortNumber(noVotesSum) }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium">
                    No Votes ₳ Sum
                </dt>
            </dl>
        </div>
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

let talliesSum$ = ref(null);
let yesVotesSum = ref(null);
let noVotesSum = ref(null);
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
    axios.get(route('catalystExplorerApi.talliesSum'), { params })
        .then((res) => {
            talliesSum$.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });

    axios.get(route('catalystExplorer.metrics.totalYesVotes'), { params })
        .then((res) => yesVotesSum.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    axios.get(route('catalystExplorer.metrics.totalNoVotes'), { params })
        .then((res) => noVotesSum.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();

</script>
