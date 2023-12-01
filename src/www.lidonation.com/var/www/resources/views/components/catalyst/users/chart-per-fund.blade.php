@props([
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    'data' => [200, 150, 350, 225, 125],
    'dataType' => null,
    'chartName' => 'chartName',
    'modelId' => 'modelId',
])
<div x-data="{
    labels: @js($labels),
    values: @js($data),
    chartName: @js($chartName),
    modelId: @js($modelId),
    dataType: @js($dataType),
    chart: null, 
    init() {
        this.setupChart();
        Livewire.on('ownMetricsToggle', async () => {
            this.chart.destroy();
            this.setupChart();
        });
    },
    setupChart() {
        this.chart = new Chart(this.$refs.canvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: this.labels,
                datasets: [{
                    data: this.values,
                    barThickness: 12,
                    backgroundColor: '#4395bc',
                    borderColor: '#4395bc',
                    borderWidth: 1,
                    borderRadius: 3,
                    aspectRatio: 3,
                    borderSkipped: false,
                    minBarLength: 3,
                    dataType: this.dataType,
                }],
            },
            options: {
                responsive: true,
                interaction: { intersect: false },
                scales: {
                    x: {
                        display: false,
                        min: 0,
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        display: false,
                        min: 0,
                        grid: {
                            display: false,
                        },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        displayColors: false,
                        callbacks: {
                            label(context) {
                                const point = context.dataset.data[context.dataIndex];
                                const dataType = context.dataset.dataType[context.dataIndex];
                                switch (dataType) {
                                    case 'USD':
                                        return new Intl.NumberFormat('en-US', {
                                            style: 'currency',
                                            currency: 'USD',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0,
                                        }).format(point);
                                    case 'percent':
                                        return `${point}%`;
                                    case 'ADA':
                                        return `₳${new Intl.NumberFormat('en-US',{minimumFractionDigits: 0,maximumFractionDigits: 0}).format(point)}`;
                                    default:
                                        return point;
                                }
                            },
                        },
                    },
                },
            },
        });
    },
}">
    <canvas x-ref="canvas" class="p-0 bg-transparent rounded-sm w-44h-24 "></canvas>
</div>