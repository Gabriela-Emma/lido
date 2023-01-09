@props([
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    'data' => [200, 150, 350, 225, 125],
    'dataType' => 'number',
    'type' => 'bar',
])
<div x-data="{
    labels: @js($labels),
    values: @js($data),
    init() {
        let chart = new Chart(this.$refs.canvas.getContext('2d'), {
            type: @js($type),
            data: {
                labels: this.labels,
                datasets: [{
                    data: this.values,
                    barThickness: 44,
                    backgroundColor: '#2596be',
                    borderColor: '#3aa0c4',
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
                interaction: { intersect: true },
                scales: {
                    x: {
                        display: true,
                        min: 0,
                        grid: {
                          display: true
                        }
                    },
                    y: {
                        display: true,
                        min: 0,
                        grid: {
                          display: true
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
    <canvas x-ref="canvas" class="bg-transparent rounded-sm p-0  w-44h-24 "></canvas>
</div>
