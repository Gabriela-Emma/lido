<template>
    <div class="flex flex-wrap items-start justify-between">
        <div class="text-teal-600">
            <h2 class="mb-0 xl:text-3xl">
                Ada Power Ranges
            </h2>
            <p>
                The pie by Ada Power
            </p>
        </div>
        <div v-if="attachmentLink">
            <Attachment :attachementLink="attachmentLink" />
        </div>
    </div>

    <div class="my-auto" v-if="chartData1Ada1Vote$">
        <AdaPowerRangesPie :chartData="chartData1Ada1Vote$" :options="chartOptions" />
    </div>
</template>

<script setup lang="ts">
import AdaPowerRangesPie from './AdaPowerRangesPie.vue';
import Attachment from './Attachment.vue';

const props = defineProps<{
    attachmentLink: string
    chartData1Ada1Vote$: {}
    chartOptions: {}
}>()
</script>