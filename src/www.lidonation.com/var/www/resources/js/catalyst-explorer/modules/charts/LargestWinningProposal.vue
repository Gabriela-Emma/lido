<template>
    <dl class="relative flex flex-col justify-between h-full">
        <div class="absolute top-0 right-0 px3">
            <a v-if="amount_requested > 0" type="button" :href="link ?? null" target="_blank"
                class="inline-flex items-center px-1.5 py-1 border border-white hover:border-accent-700 shadow-xs text-xs font-semibold rounded-sm text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-600 hover:bg-accent-600">
                View
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
        <dd class="pointer-events-none">
            <div class="relative text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                <div v-if="amount_requested > 0">
                    ${{ $filters.shortNumber(amount_requested) }}
                </div>
                <div v-else>
                    0
                </div>
            </div>
        </dd>
        <dt class="mt-3 text-lg font-medium text-gray-200 truncate pointer-events-none">
            Largest Winning Proposal
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

let amount_requested = ref(null);
let largestFundedProposalObject = ref(null);
let link = ref(null);

function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

watch([largestFundedProposalObject], () => {
    amount_requested.value = largestFundedProposalObject.value.amount_requested;
    link.value = largestFundedProposalObject.value.link;
});

let query = () => {
    let params = getQueryData()
    axios.get(`${usePage().props.base_url}/catalyst-explorer/metrics/largestFundedProposalObject`, { params })
        .then((res) => largestFundedProposalObject.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
query();

</script>
