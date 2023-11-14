<template>
    <div class="canvas-pie">
        <Scatter :data="chartData" :options="options" />
    </div>
</template>

<script lang="ts" setup>
import { Chart as ChartJS, Tooltip, Legend, LineElement, PointElement, LinearScale } from 'chart.js';
import { Scatter } from 'vue-chartjs';

ChartJS.register(LinearScale, PointElement, LineElement, Tooltip, Legend)

withDefaults(
    defineProps<{
        chartData,
        options
    }>(),
{});

</script>

<style>
.canvas-scatter {
    height: 600px;
}
</style>
