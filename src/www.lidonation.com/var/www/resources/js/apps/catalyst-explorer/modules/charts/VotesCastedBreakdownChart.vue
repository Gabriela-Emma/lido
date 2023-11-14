<template>
    <div class="text-blue-dark-500">
        <h2 class="mb-0 xl:text-3xl">
            Votes Cast Breakdown
        </h2>
        <p>
            Breakdown of votes cast by voting keys.
        </p>
    </div>
    <div class="relative w-full mt-8" v-if="props.loadingVotesRanges">
        <ul role="list" class="divide-y divide-gray-200 max-h-[42rem] overflow-y-auto">
            <li v-for="index in 6" :key="index">
                <PulseLoading />
            </li>
        </ul>
    </div>
    <div class="relative w-full mt-8" v-if="!props.loadingVotesRanges">
        <ul role="list" class="divide-y divide-gray-200 max-h-[42rem] overflow-y-auto">
            <li v-for="(range) in votesRanges" class="flex items-center justify-start w-full gap-4 py-4">
                <div class="flex items-center justify-center w-20 h-20 p-2 text-center rounded-full bg-slate-300">
                    <span class="text-base">{{ range['key'] }} Votes</span>
                </div>

                <div class="">
                    <p class="text-lg lg:text-xl xl:text-2xl 2xl:text-3xl text-slate-500">
                        {{ range['count'].toLocaleString() }}
                        <span class="text-slate-300 text-md lg:text-lg xl:text-2xl 2xl:text-2xl">
                            <span v-if="range['count'] == 1">Wallet</span>
                            <span v-if="range['count'] > 1">Wallets</span>
                        </span>
                    </p>
                </div>

                <div class="pr-2 ml-auto">
                    <p class="text-md lg:text-lg xl:text-2xl text-slate-500">
                        {{
                            $filters.shortNumber(range['total'], 2)
                        }}
                    </p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import PulseLoading from './PulseLoading.vue';

const props = defineProps<{
    votesRanges?: { 'key': string, 'count': number, 'total': number }[];
    loadingVotesRanges?: boolean;
}>()
</script>
