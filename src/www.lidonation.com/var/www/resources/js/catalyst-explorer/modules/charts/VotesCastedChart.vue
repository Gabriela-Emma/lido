<template>
    <div class="flex flex-wrap items-start justify-between">
        <div class="text-teal-600">
            <h2 class="mb-0 xl:text-3xl">
                Votes Casted
            </h2>
            <p>Pie chart votes casted</p>
        </div>
    </div>

    <div class="my-auto" v-if="chartDataVotesCasted$">
        <AdaPowerRangesPie :chartData="chartDataVotesCasted$" :options="chartOptions" />
    </div>
</template>

<script setup lang="ts">
import AdaPowerRangesPie from './AdaPowerRangesPie.vue';

const props = defineProps<{
    chartDataVotesCasted$:{};
    chartOptions:{};
}>()
</script>