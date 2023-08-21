<template>
    <div v-for="filter in filteringOptions" class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]" @click="emit('filter',filter.param)">
        <span :class="{ 'bg-teal-600': 1 }"
            class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
            aria-hidden="true"></span>
        <span class="ml-3 text-gray-600">
            <p>{{ filter.title }}</p>
            <span class="mt-2 text-sm">
               {{ filter.description}}
            </span>
        </span>
    </div>
</template>

<script lang="ts" setup>

const emit = defineEmits<{
    (e: 'filter', filter: string): void;
}>()

const filteringOptions = [
    {
        "title": "Quick Pitches",
        "description": "Proposals with Quick Pitches.",
        "param": "quickPitchProposals"
    },
    {
        "title": "Ideafest Proposals",
        "description": "Projects presented at Ideafest!",
        "param": "ideafestProposals"
    },
    {
        "title": "Women Proposals",
        "description": "Proposals By Women.",
        "param": "womanProposals"
    },
    {
        "title": "First Timers",
        "description": "Proposals from first time members!",
        "param": "firstTimers"
    },
    {
        "title": "One timers",
        "description": "Members with only 1 proposal",
        "param": "oneTimers"
    },
    {
        "title": "Completed Proposers",
        "description": "Teams that have completed at least 1 proposal",
        "param": "completedProposers"
    },
    {
        "title": "Small Cap",
        "description": "Proposals with budgets <= 10K",
        "param": "smallProposals"
    },
    {
        "title": "Medium Cap",
        "description": "Proposals with budgets between 75K & 250K",
        "param": "smallProposals"
    },
    {
        "title": "Large Cap",
        "description": "Proposals with budgets >= 250K",
        "param": "100KProposals"
    },
]



</script>