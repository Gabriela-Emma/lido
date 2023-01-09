@props([
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    'data' => [200, 150, 350, 225, 125],
    'dataType' => 'number',
    'chartName' => 'chartName',
    'modelId' => 'modelId',
])
<div x-data="{
    labels: @js($labels),
    values: @js($data),
    chartName: @js($chartName),
    modelId: @js($modelId),
    init() {
        Livewire.on('ownMetricsToggle', async () => {
            this.values = await $wire.getMetricData(this.chartName, this.modelId);
        });
        let chart = new Chart(this.$refs.canvas.getContext('2d'), {
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
                    dataType: @js($dataType)
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
                          display: false
                        }
                    },
                    y: {
                        display: false,
                        min: 0,
                        grid: {
                          display: false
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        displayColors: false,
                        callbacks: {
                            label(point) {
                                switch (point.dataset.dataType) {
                                    case 'currency':
                                        return new Intl.NumberFormat(
                                        'en-US',
                                         {
                                            style: 'currency',
                                            currency: 'USD',
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                         }).format(point.raw)
                                    case 'percent':
                                        return `${point.raw}%`;
                                    default:
                                        return point.raw;
                                }
                            }
                        }
                    }
                }
            }
        })

        this.$watch('values', () => {
            chart.data.labels = this.labels
            chart.data.datasets[0].data = this.values
            chart.update()
        })
    }
}">
    <canvas x-ref="canvas" class="bg-transparent rounded-sm p-0 w-44h-24 "></canvas>
</div>
