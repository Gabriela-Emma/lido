@props([
    'labels' => ['Hello', 'world', 'normally', 'you', 'want', 'more', 'words', 'than', 'this' ],
    'data' => [90, 80, 70, 60, 50, 40, 30, 20, 10],
    'dataType' => 'number',
])
<div x-data="{
    labels: @js($labels),
    values: @js($data),
    init() {
        let chart = new Chart(this.$refs.canvas.getContext('2d'), {
            type: 'wordCloud',
            data: {
                labels: this.labels,
                datasets: [{
                    data: this.values,
                    dataType: @js($dataType)
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true,
                padding: 1,
                aspectRatio: 2,
                fit: true,
                title: {
                      display: false,
                      text: 'Chart.js Word Cloud'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        displayColors: false,
                        enabled: false
                    }
                }
            }
        })

        this.$watch('values', () => {
            chart.data.labels = this.labels
            chart.data.datasets[0].data = this.values
            chart.update()
        });

    }
}" class="relative overflow-hidden">
    <canvas class="w-[26rem] h-[40rem] md:w-[62rem] lg:w-[50rem] 3xl:w-[64rem] 3xl:h-[28rem] mx-auto" x-ref="canvas"></canvas>
</div>
