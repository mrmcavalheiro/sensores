

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainChartCtx = document.getElementById('mainChart').getContext('2d');
        let mainChart = new Chart(mainChartCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['mainChartData']['labels']) !!},
                datasets: [{
                    label: 'Main Dataset',
                    data: {!! json_encode($chartData['mainChartData']['data']) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        @foreach ($chartData['smallChartsData'] as $index => $chart)
            new Chart(document.getElementById('smallChart{{ $index }}').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chart['labels']) !!},
                    datasets: [{
                        label: 'Dataset {{ $index + 1 }}',
                        data: {!! json_encode($chart['data']) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        @endforeach
    });

    function updateMainChart(index) {
        const chart = {!! json_encode($chartData['smallChartsData']) !!}[index];
        mainChart.data.labels = chart['labels'];
        mainChart.data.datasets[0].data = chart['data'];
        mainChart.update();
    }
</script>
