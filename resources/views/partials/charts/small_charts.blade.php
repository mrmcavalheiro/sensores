<div class="container">
    <div class="row">
        @foreach ($chartData['smallChartsData'] as $index => $chart)
            <div class="col s12 m6 l3">
                <canvas id="smallChart{{ $index }}" width="200" height="200" onclick="updateMainChart({{ $index }})"></canvas>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const smallChartsData = {!! json_encode($chartData['smallChartsData']) !!};

        smallChartsData.forEach((chart, index) => {
            new Chart(document.getElementById('smallChart' + index).getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chart.labels,
                    datasets: [{
                        label: 'Dataset ' + (index + 1),
                        data: chart.data,
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
        });
    });

    function updateMainChart(index) {
        const chart = {!! json_encode($chartData['smallChartsData']) !!}[index];
        const mainChart = Chart.getChart('mainChart');
        mainChart.data.labels = chart.labels;
        mainChart.data.datasets[0].data = chart.data;
        mainChart.update();
    }
</script>
