@extends('site.layout')
@section('title','Página Home')

@section('content')

@php
    use Illuminate\Support\Facades\Log;
@endphp

<!-- Seções de Conteúdo -->
<section id="graficos" class="content-section">
    <div class="row">
        <!-- Gráficos -->
        <div class="col s12">
            <div class="new_card main_chart_wrapper">
                <h3 id="chart-title1">Gráfico de Umidade Volumétrica do Solo</h3>
                <div class="main_chart_selectors">
                    <!-- Dropdown Trigger -->
                    <a class='dropdown-trigger btn selector_button' href='#' data-target='dropdown_regions'>Selecione a Região</a>

                    <!-- Dropdown Structure -->
                    <ul id='dropdown_regions' class='dropdown-content selector-content'>
                        @foreach($regions as $index => $region)
                            <li>
                                <a href="javascript:void(0);" onclick="selectRegion('{{ $region['id'] }}', '{{ $region['description'] }}')" title="{{ $region['description'] }}" class="{{ $index === 0 ? 'active' : '' }}" data-id="{{ $region['id'] }}">
                                    {{ Str::limit($region['description'], 70) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Dropdown Trigger -->
                    <a class='dropdown-trigger btn selector_button' href='#' data-target='dropdown_period'>Selecione o Período</a>

                    <!-- Dropdown Structure -->
                    <ul id='dropdown_period' class='dropdown-content selector-content'>
                        @foreach($periods as $index => $period)
                            <li>
                                <a href="javascript:void(0);" onclick="selectPeriod({{ $index }}, '{{ $period }}')" class="{{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                    {{ $period }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="main_chart_selected">
                    <h4><b>Região</b>: <span id="region-selected">{{ $regions[0]['description'] }}</span></h4>
                    <h4><b>Período</b>: <span id="period-selected">{{ $periods[0] }}</span></h4>
                </div>
                <div class="grafico-container">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section id="sobre" class="content-section">
    @include('partials.home.apresentacao')
</section> --}}

@include('partials.home.mapa')

@include('partials.home.parallax')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let mainChartInstance = null;
    let selectedPeriod = '1 semana'; // Período padrão

    function selectRegion(id, description) {
        document.querySelectorAll('#dropdown_regions li a').forEach(item => item.classList.remove('active'));
        document.querySelectorAll('#dropdown_regions li a').forEach(item => {
            if (item.dataset.id == id) {
                item.classList.add('active');
            }
        });

        const chartTitleElement = document.getElementById('region-selected');
        if (chartTitleElement) {
            chartTitleElement.textContent = description;
        } else {
            console.error('Element with id "region-selected" not found in the DOM.');
        }

        updateChartData(id, selectedPeriod);
    }

    function selectPeriod(index, period) {
        document.querySelectorAll('#dropdown_period li a').forEach(item => item.classList.remove('active'));
        document.querySelectorAll(`#dropdown_period li a`).forEach(item => {
            if (item.dataset.index == index) {
                item.classList.add('active');
            }
        });
        selectedPeriod = period;

        const chartTitleElement = document.getElementById('period-selected');
        if (chartTitleElement) {
            chartTitleElement.textContent = period;
        } else {
            console.error('Element with id "period-selected" not found in the DOM.');
        }

        updateChartData(getSelectedRegion(), period);
    }

    function getSelectedRegion() {
        const selectedRegion = document.querySelector('#dropdown_regions li a.active');
        return selectedRegion ? selectedRegion.dataset.id : null;
    }

    function updateChartData(regionId, period) {
        console.log('updateChartData chamada com regionId:', regionId, 'e period:', period);

        if (!regionId || !period) {
            console.error('Region ID ou period está faltando');
            return;
        }

        fetch('/update-chart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ region_id: regionId, period: period })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Dados recebidos:', data);
            updateChart(data.chartData.mainChartData);
        })
        .catch(error => console.error('Erro ao atualizar gráfico:', error));
    }

    function updateChart(data) {
        if (mainChartInstance) {
            mainChartInstance.destroy();
        }

        const ctx = document.getElementById('mainChart').getContext('2d');
        mainChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Soil VWC S1',
                        data: data.dataS1,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Soil VWC S2',
                        data: data.dataS2,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Chamada inicial para carregar o gráfico
        const initialRegionId = getSelectedRegion();
        if (initialRegionId) {
            updateChartData(initialRegionId, selectedPeriod);
        }

        // Inicialização do dropdown
        const elems = document.querySelectorAll('.dropdown-trigger');
        const instances = M.Dropdown.init(elems, { hover: false, constrainWidth: false });
    });
</script>

@endsection
