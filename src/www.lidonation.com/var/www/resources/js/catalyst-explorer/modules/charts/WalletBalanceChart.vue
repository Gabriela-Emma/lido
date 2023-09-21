<template>
    <div class="flex flex-wrap items-start justify-between">
        <div class="text-teal-600">
            <h2 class="mb-0 xl:text-3xl">
                1 stake key 1 Vote Ranges
            </h2>
            <p>Pie chart of wallet balance</p>
        </div>
        <div v-if="attachmentLink">
            <Attachment :attachementLink="attachmentLink" />
        </div>
    </div>

    <div class="my-auto" v-if="chartData1Registration1Vote$">
        <AdaPowerRangesPie :chartData="chartData1Registration1Vote$" :options="chartOptions" />
    </div>
</template>

<script setup lang="ts">
import AdaPowerRangesPie from './AdaPowerRangesPie.vue';
import Attachment from './Attachment.vue';

const props = defineProps<{
    attachmentLink:string
    chartData1Registration1Vote$:{}
    chartOptions:{}
}>()
</script>