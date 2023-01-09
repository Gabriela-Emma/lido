@props([
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    'data' => [200, 150, 350, 225, 125],
    'dataType' => 'number',
    'type' => 'doughnut',
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
                    backgroundColor: [
                      '#a3899d',
                      '#917289',
                      '#7e5a75',
                      '#6c4262',
                      '#5a2b4e',
                      '#48143b',
                      '#401235',

                      '#66b5d1',
                      '#50abcb',
                      '#3aa0c4',
                      '#2596be',


                      '#fce33b',
                      '#fcdf23',
                      '#fcdc0b',
                      '#e2c609',

                      '#ff8700',
                      '#4bb92f',
                      '#8d00ff',
                      '#E4578A'
                    ],
                    borderSkipped: false,
                    dataType: @js($dataType)
                }],
            },
            options: {
                responsive: true,
                interaction: { intersect: true },
                plugins: {
                    legend: { display: true },
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
