<template>
    <div class="canvas-pie">
        <Doughnut :data="chartData" :options="options" />
    </div>
</template>

<script lang="ts">
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Doughnut } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)

export default {
    name: 'PieChart',
    components: { Doughnut },
    props: {
        chartData: {
            type: Object,
            required: true
        },
        options: {
            type: Object,
            default: () => {}
        }
    }
}
</script>

<style>
.canvas-pie {
    height: 600px;
}
</style>
