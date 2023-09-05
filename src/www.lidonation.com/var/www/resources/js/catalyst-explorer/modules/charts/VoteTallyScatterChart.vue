<template>
    <div class="canvas-pie">
        <Scatter :data="chartData" :options="options" />
    </div>
</template>

<script lang="ts" setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Scatter } from 'vue-chartjs';

ChartJS.register(ArcElement, Tooltip, Legend);

defineProps<{
    chartData: {
        type: Object,
        required: true
    },
    options: {
        type: Object,
        default: () => {}
    }
}>();

</script>

<style>
.canvas-scatter {
    height: 600px;
}
</style>
