<template>
    <div class="relative flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg group">
        <div class="bg-gray-200 aspect-w-2 aspect-h-2 group-hover:opacity-75 sm:aspect-none sm:h-60">
            <img :alt="challenge.title" :src="challenge.thumbnail_url ?? challenge.hero_url" class="object-cover object-center w-full h-full sm:w-full sm:h-full">
        </div>
        <div class="flex flex-col flex-1 p-4 space-y-2">
            <h3 class="text-xl font-medium text-gray-900">
                <a :href="challenge.link " target="_blank" rel="noreferrer">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ challenge.title }}
                </a>
            </h3>
            <p class="text-sm text-gray-500">{{ challenge.excerpt }}</p>
            <div class="flex flex-col justify-end flex-1">
                <p class="text-base italic text-gray-700">{{ challenge.proposals_count }}
                    proposals</p>
                <p class="text-lg font-medium text-gray-900">
                    Budget: <span class="font-bold">{{ $filters.currency(challenge.amount, fund.currency)
                    }}</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Fund from "../../models/fund"

const props = defineProps<{
    challenge: Fund
    fund: Fund
}>()

</script>